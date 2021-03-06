function checkLoggued(url)
{
  if(userId == "") {
    //TODO Replace with a modal version of the login page
    bootbox.confirm("You need to be loggued to do this, login first ?",
          function(result) {
            if (result) 
              window.location.href = baseUrl+"/"+moduleId+"/person/login?backUrl="+url;
     });
  } else
    return true;
}

function ajaxPost(id,url,params,callback, datatype)
{
	mylog.log(id,url,params);
  /*if(dataType == null)
    dataType = "json";*/
	if(datatype != "html" )
		$(id).html("");
	$.ajax({
	    url:url,
	    data:params,
	    type:"POST",
	  //  dataType: "json",
	    success:function(data) {
            if(datatype === "html" )
    			$(id).html(data);
    	  	else if(typeof data.msg === "string" )
    	    	toastr.success(data.msg);
    	    else
    	      	$("#"+id).html(JSON.stringify(data, null, 4));
    	      		
          	if( typeof callback === "function")
              callback(data,id);
	    },
	    error:function (xhr, ajaxOptions, thrownError){
	     mylog.error(thrownError);
	    } 
	  });
}

function getAjax(id,url,callback,datatype,blockUI)
{
  $.ajaxSetup({ cache: true});
  mylog.log("getAjax",id,url,callback,datatype,blockUI)
    if(blockUI)
        $.blockUI({
            message : '<i class="fa fa-spinner fa-spin"></i> Processing... <br/> '+
                '<blockquote>'+
                  '<p>Art is the heart of our culture.</p>'+
                '</blockquote> '
        });
  
    if(datatype != "html" )
        $(id).html( "<div class='cblock'><div class='centered'><i class='fa fa-cog fa-spin fa-2x icon-big text-center'></i> Loading</div></div>" );
  
    $.ajax({
        url:url,
        type:"GET",
        cache: true,
        success:function(data) {
          if (data.error) {
            mylog.warn(data.error);
            toastr.error(data.error.msg);
          } else if(datatype === "html" )
            $(id).html(data);
          else if(datatype === "norender" )
            mylog.log("no render",url)
          else if( typeof data === "string" )
            toastr.success(data);
          else
              $(id).html( JSON.stringify(data, null, 4) );
  
          if( typeof callback === "function")
            callback(data,id);
          if(blockUI)
            $.unblockUI();
        },
        error:function (xhr, ajaxOptions, thrownError){
          //mylog.error(thrownError);
          $.blockUI({
              message : '<div class="title-processing homestead text-red"><i class="fa fa-warning text-red"></i> Oups !! 404 ERROR<br> La page que vous demandez ne peut être trouvée ... </div>'
              +'<a class="thumb-info" href="'+moduleUrl+'/images/proverb/from-human-to-number.jpg" data-title="Il n\'existe pas d\'évolution sans erreur."  data-lightbox="all">'
              + '<img src="'+moduleUrl+'/images/proverb/from-human-to-number.jpg" style="border:0px solid #666; border-radius:3px;"/></a><br/><br/>',
              timeout: 3000 
          });
          setTimeout(function(){loadByHash('#')},3000);
          if(blockUI)
            $.unblockUI();
        } 
    });
}
/*
what can be a simple string which will go into the title bar 
or an aboject with properties like title, icon, desc
getModal({title:"toto"},"/communecter/project/projectsv")
 */
function getModal(what, url,id)
{
	
	loaded = {};
	$('#ajax-modal').modal("hide");
	if(id)
		url = url+id;
	mylog.log("getModal",what,"url",url,"event",id);
	//var params = $(form).serialize();
	//$("#ajax-modal-modal-body").html("<i class='fa fa-cog fa-spin fa-2x icon-big'></i> Loading");
	$('body').modalmanager('loading'); 
  $.unblockUI();
  $("#ajax-modal-modal-title").html("<i class='fa fa-refresh fa-spin'></i> Chargement en cours. Merci de patienter.");
  $("#ajax-modal-modal-body").html(""); 
  $('#ajax-modal').modal("show");
	$.ajax({
        type: "GET",
        url: baseUrl+url
        //dataType : "json"
        //data: params
    })
    .done(function (data) 
    {
        if (data) {     
        	/*if(!selectContent)
        		selectContent = data.selectContent;*/
        	title = (typeof what === "object" && what.title ) ? what.title : what;
        	icon = (typeof what === "object" && what.icon ) ? what.icon : "fa-pencil";
        	desc = (typeof what === "object" && what.desc ) ? what.desc+'<div class="space20"></div>' : "";

    		  $("#ajax-modal-modal-title").html("<i class='fa fa-"+icon+"'></i> "+title);
          $("#ajax-modal-modal-body").html(desc+data); 
          $('#ajax-modal').modal("show");
        } else {
           mylog.error("bug get "+what, url,id);
        }
    })
    .error(function(data){
      mylog.log("error getModal");
      mylog.dir(data);
    });
}

//js ex : "/themes/ph-dori/assets/plugins/summernote/dist/summernote.min.js"
//css ex : "/themes/ph-dori/assets/plugins/summernote/dist/summernote.css"
function lazyLoad (js,css, callback) { 
    mylog.warn("lazyLoad",js);
    if( !$('script[src="'+baseUrl+js+'"]').length )
    {
        if(css)
            $("<link/>", {
               rel: "stylesheet",
               type: "text/css",
               href: css 
            }).appendTo("head");
        $.getScript( js, function( data, textStatus, jqxhr ) {
          if( typeof callback === "function")
            callback();
        });
    } else {
        if( typeof callback === "function")
            callback();
    }

}


/* --------------------------------------------------------------- */

function toggle(id,siblingsId,activate)
{
	mylog.log("toggle",id,siblingsId);
  $(siblingsId).addClass("hide");
  if(activate)
    $(siblingsId+"Btn").removeClass("active");
	//if( !$("."+id).is(":visible") ) 
	$(id).removeClass("hide");
  if(activate){
    idT = id.split(",");
    $(idT[0]+"Btn").addClass("active");
  }
}

/* --------------------------------------------------------------- */

function scrollTo(id)
{
	if( $(id).length )
	{
		//mylog.log(".my-main-container initscrollTo ", id);
    //mylog.log($(id).position().top);
    
	 	$(".my-main-container").animate({ scrollTop: $(id).position().top-50 }, 1200);
	}
}

/* --------------------------------------------------------------- */

function Object2Array(obj)
{
	jsonAr =[];
	$.each(obj,function(k,v)
	{
		v.id = k;
		delete v._id;
		jsonAr.push(v);
	});
	mylog.dir(jsonAr);
	return jsonAr;
}

/* --------------------------------------------------------------- */

function arrayCompare(a1, a2) {
  if (a1.length != a2.length) return false;
  var length = a2.length;
  for (var i = 0; i < length; i++) {
    if (a1[i] !== a2[i]) return false;
  }
  return true;
}

/* --------------------------------------------------------------- */

function inArray(needle, haystack) {
  var length = haystack.length;
  for(var i = 0; i < length; i++) {
    if(typeof haystack[i] == 'object') {
      if(arrayCompare(haystack[i], needle)) return true;
    } else {
      if(haystack[i] == needle) return true;
    }
  }
  return false;
}

/* ------------------------------- */

/*function log(msg,type){
  if(debug){
     try {
      if(type){
        switch(type){
          case 'info': mylog.info(msg); break;
          case 'warn': mylog.warn(msg); break;
          case 'debug': mylog.debug(msg); break;
          case 'error': mylog.error(msg); break;
          case 'dir': mylog.dir(msg); break;
          default : mylog.log(msg);
        }
      } else
            mylog.log(msg);
    } catch (e) { 
       //alert(msg);
    }
  }
}*/

/* --------------------------------------------------------------- */

function showAsColumn(resp,id)
{
	//log(resp,"dir");
	if($("#"+id).hasClass("columns"))
	{
		mylog.log("rebuild");
		$("#"+id).columns('setMaster', Object2Array(resp) );
		$("#"+id).columns('create');
	} else {
		$("#"+id).columns({
	      data:Object2Array(resp),
	      schema:[
		      {"header":"Name","key":"name"},
		      {"header":"Edit","key":"id", "template":"<a class='openModal' href='{{id}}' data-id='{{id}}' data-name='{{name}}'>{{id}}</a>"}
		  ]
	    });
	    
	    $(".openModal").click(function(e){
	    	e.preventDefault();
	    	openModal($("#getbyMicroformat").val(),$("#getbyCollection").val(),this.dataset.id,"dynamicallyBuild");
	    })
	}
}

/* --------------------------------------------------------------- */

function slugify (value) {    
	var rExps=[
	{re:/[\xC0-\xC6]/g, ch:'A'},
	{re:/[\xE0-\xE6]/g, ch:'a'},
	{re:/[\xC8-\xCB]/g, ch:'E'},
	{re:/[\xE8-\xEB]/g, ch:'e'},
	{re:/[\xCC-\xCF]/g, ch:'I'},
	{re:/[\xEC-\xEF]/g, ch:'i'},
	{re:/[\xD2-\xD6]/g, ch:'O'},
	{re:/[\xF2-\xF6]/g, ch:'o'},
	{re:/[\xD9-\xDC]/g, ch:'U'},
	{re:/[\xF9-\xFC]/g, ch:'u'},
	{re:/[\xC7-\xE7]/g, ch:'c'},
	{re:/[\xD1]/g, ch:'N'},
	{re:/[\xF1]/g, ch:'n'} ];

	// converti les caractères accentués en leurs équivalent alpha
	for(var i=0, len=rExps.length; i<len; i++)
	value=value.replace(rExps[i].re, rExps[i].ch);

	// 1) met en bas de casse
	// 2) remplace les espace par des tirets
	// 3) enleve tout les caratères non alphanumeriques
	// 4) enlève les doubles tirets
	return value.toLowerCase()
	.replace(/\s+/g, '-')
	.replace(/[^a-z0-9-]/g, '')
	.replace(/\-{2,}/g,'-');
};

var jsonHelper = {
  /*
  
   */
  a : {x : {b : 2} },
  
  test : function(){
    mylog.log("init",JSON.stringify(this.a));

    this.getValueByPath( this.a,"x.b");
    mylog.log("this.a set x.b => 1000");    
    this.setValueByPath( this.a,"x.b",1000);
    this.getValueByPath( this.a,"x.b")
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a.x set b => 2000");
    this.setValueByPath( this.a.x,"b",2000);
    this.getValueByPath( this.a,"x.b");
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a.x set b => {m:1000}");
    this.setValueByPath( this.a.x,"b",{m:1000});
    this.getValueByPath( this.a,"x.b");
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a set x.b.a => 4000");
    this.setValueByPath( this.a,"x.b.a",4000);
    this.getValueByPath( this.a,"x.b");
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a set x.b.a => {m:1000}");
    this.getValueByPath( this.a,"x.b.a");
    this.setValueByPath( this.a,"x.b.a",{m:1000});
    this.getValueByPath( this.a,"x.b.a");
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a set x.b.a.b.c.d => {xx:1000}");
    this.getValueByPath( this.a,"x.b.a.b.c.d");
    this.setValueByPath( this.a,"x.b.a.b.c.d",{xx:1000,yy:25000});
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a reset x.b.a.b.c.d.yy => 100000");
    this.getValueByPath( this.a,"x.b.a.b.c.d.yy");
    this.setValueByPath( this.a,"x.b.a.b.c.d.yy",100000);
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a delete x.b.a.b.c.d.yy");
    this.deleteByPath( this.a,"x.b.a.b.c.d.yy");
    mylog.log(JSON.stringify(this.a));

    mylog.log("this.a delete x.b.a.b.c.d.yy");
    this.deleteByPath( this.a,"x.b.a.b.c.d.yy");
    mylog.log(JSON.stringify(this.a));
  },
  strTest:"\n>name:xxx"+
      "\n>desc:yyyyyyyyyy"+
      "\n>email:zzzz@yyy.com"+
      "\n>adr:102 rue ppppppp"+
      "\n>cp:97421"+
      "\n>latlon:21,55"+
      "\n>type:NGO"+
      "\n>admin:admin",
  testStringForm : function(){
    mylog.log("strTest",this.strTest);
    mylog.warn("------------string to json------------------");
    this.stringFormtoJson( this.strTest );
    mylog.warn("------------building form ------------------");
    this.stringFormtoJson( this.strTest, "testForm" );
    mylog.warn("------------ form serialised ------------------");
    mylog.log( $("#testForm").serialize() );
    mylog.warn("------------ form serialised as JSON ------------------");
    mylog.dir( $("#testForm").serializeFormJSON() );
  },
  /* 
    Convert a structured string to json object
    the simplest Form in internet history
    can be used as a HTML hidden Form builder as well
  */
  stringFormtoJson : function( str,buildForm ){
    mylog.log("strTest",str);
    separator = "\n>";
    fields = str.split(separator);
    res = {};
    if(buildForm){
        if(!$("#"+buildForm).length ){
          $(".my-main-container").append( $("<form>", {id: buildForm, "method": "POST"}) );
          $(".my-main-container").prepend( $("<span>", {class: "errorHandler"}) );
        }
        else
          $("#"+buildForm).html("");
    }
    $.each(fields,function(i,v) {
      mylog.log(v);
      keyVal = v.split(":");
      if(  typeof keyVal[1] != "undefined" && keyVal[1] != "" ){
        res[ keyVal[0] ] = keyVal[1];
        if(buildForm)
          $("#"+buildForm).append("<input type='hidden' id='"+keyVal[0]+"' name='"+keyVal[0]+"' value='"+keyVal[1]+"'/>");
      }
    })
    mylog.dir(res);
    return res;
  },
  /*
  srcObj = any json OBJCT
  path =  STRING "node1.node2.node3"
   */
  getValueByPath : function(srcObj,path)
  {
    node = srcObj;
    //mylog.log("path",path);
    if( !path )
      return node;
    else if( typeof path == "object" && path.value )
    {
      return path.value;
    }
    else if( path.indexOf(".") )
    {
      pathArray = path.split(".");
      $.each(pathArray,function(i,v){
        if(node != undefined && node[v] != undefined)
          node = node[v];
        else {
          node = undefined; 
          return;
        }
      });
      return node;
    }  
    else if(node[path])
      return node[path];
    else
      return "";
  },
  setValueByPath : function(srcObj,path,value)
  {
    node = srcObj;
    if( !path ){
      node = value;
    }
    else if( path.indexOf(".") )
    {
      pathArray = path.split(".");
      nodeParent = null;
      lastKey = null;
      $.each(pathArray,function(i,v){
        if(!node[v]){
          //mylog.log("building node",v);
          node[v] = {};
        }
        nodeParent = node;
        node = node[v]; 
        lastKey = v;
      });
      //mylog.log(node,nodeParent,lastKey);
      nodeParent[lastKey] = value;
    }  
    else
      node[path] = value;
  },
  
  deleteByPath : function  (srcObj,path) {
    nodeParent = srcObj;
    lastChild = null;
    node = srcObj;
    if( path.indexOf(".") ){
      pathArray = path.split(".");
      if( pathArray.length )
      {
        $.each(pathArray,function(i,v){
          nodeParent = node;
          lastChild = v;
          node = node[v];
        });
      }
      delete nodeParent[lastChild];
    } else
      delete nodeParent[path];
  },
  swapJsonKeyValues : function(srcObj) {
      var one, output = {};
      for (one in srcObj) {
          if (srcObj.hasOwnProperty(one)) {
              output[srcObj[one]] = one;
          }
      }
      return output;
  },
  /*
  convert
  { "clim":75,"informatique": 223 }
  to 
  [{  "label" : "Climatisation",  "value":75},{"label" : "Climatisation", "value":75}]
   */
  Object2GraphArray : function ( srcObj )
  {
    destArray = [];
    //mylog.dir(srcObj);
    $.each(srcObj,function(k,v){
        if(v.value != 0)
            destArray.push(v);
    });
    //mylog.dir(destArray);
    return destArray;
  },

  jsonFromToJson : {

  "fromjson" : [
    {"x":1, "y": {"c" : 20, "o" : 30} },
    {"x":2, "y": {"c" : 60, "o" : 50} }
  ],
  "rules" : { 
          "a" : "x" , 
          "b" : function(obj){ return obj.y.c + obj.y.o }
          },
  "outputLine" : {"a":"", "b":""},
  "toJson" : [],
  
  "test" : function(){
    mylog.log("test");  
    this.convert();
  },
  
  "convert" : function(){
    mylog.log("convert");     
    this.toJson = [];
    $.each(this.fromJson,function(i, fromObj){

      newLine = this.outputLine;
      /*$.each(this.rules,function(keyTo, convertTo){
        mylog.log("convert rules ",fromObj,keyTo,convertTo);     
          if(typeof convertTo == "function")
            newLine[ keyTo ] = convertTo( fromObj );
          else
            newLine[ keyTo ] = fromObj[convertTo];
      });*/
        
      this.toJson.push(newLine);
    });
    return this.toJson;
  }

}

};

$.fn.serializeFormJSON = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function showDebugMap() 
{  
  if(debugMap && debugMap.length > 0)
  {
    $.each(debugMap, function (i,val) {
          mylog.dir(val);
      });
    toastr.info("check Console for "+debugMap.length+" maps");
  }else
    toastr.error("no maps to show, please do debugMap.push(something)");

}


function exists(val){
  return typeof val != "undefined";
}
function notNull(val){
  return typeof val != "undefined"
      && val != null;
}
function notEmpty(val){
  return typeof val != "undefined"
      && val != null
      && val != "";
}

function removeEmptyAttr (jsonObj) { 

    $.each(jsonObj, function(key, value){
        if (value === "" || value === null || value === undefined){
            delete jsonObj[key];
        }
    });
}

function buildSelectOptions(list,value) { 
  var html = "";
  if(list){
    $.each(list, function(optKey, optVal) {
      selected = ( value == optKey ) ? "selected" : ""; 
      html += '<option value="'+optKey+'" '+selected+'>'+optVal+'</option>';
    });
  }
  return html;
}

function buildSelectGroupOptions(list,value) { 
  var html = "";
  if(list){
    $.each(list, function(groupKey, groupVal) {
      var data = ( groupKey ) ? 'data-type="'+groupKey+'"' : "";
      html += '<optgroup label="'+groupVal.label+'" >';
        $.each(groupVal.options, function(optKey, optVal) {
          selected = ( optKey == value ) ? "selected" : ""; 
          html += '<option value="'+optKey+'" '+selected+' '+data+'>'+optVal+'</option>';
        });
      html += '</optgroup>';
    });
  }
  return html;
}