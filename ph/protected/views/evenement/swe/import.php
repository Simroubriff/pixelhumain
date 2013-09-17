<?php
    	
    	$row = 1;
    	$coaches = array();
    	$myproject = '';
    	$projects = array();
    	$created = time();
        if (($handle = fopen("upload/swe participants2012.txt", "r")) !== FALSE) 
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {
                $num = count($data);
                
                $row++;
                for ($c=0; $c < $num; $c++) 
                {
                    $line = explode("\t", $data[$c]);
                    if( !empty($line[3]) && $line[3]=="participant" )
                    {
                        echo $line[0].' '.$line[1].' '.$line[2].'<br/>';
                        $newAccount = array(
                    			'email'=>$line[2],
                                'created' => $created,
                        		'name' => $line[0].' '.$line[1],
                                'type' => "citoyen",
                                'country' =>'Réunion',
                                'events'=>array(new MongoId("523321c7c073ef2b380a231c"))
                                );
                        $account = Yii::app()->mongodb->citoyens->findOne(array("email"=>$line[2]));
                        if($account){
                            Yii::app()->mongodb->citoyens->update(array("_id" => new MongoId($account["_id"])), array('$push' => array("events"=>new MongoId("523321c7c073ef2b380a231c"))));
                            $newAccount["_id"] = $account["_id"];
                        }
                        else
                            Yii::app()->mongodb->citoyens->insert($newAccount);
                        //add a participant
                        $where = array("_id" => new MongoId("523321c7c073ef2b380a231c"));	
                        Yii::app()->mongodb->group->update($where, array('$push' => array("participants"=>$newAccount["_id"])));
                        
                        //add details into statupweekend table
                        $newAccount['type']='participant';
                        if(!empty($line[6]))
                            $newAccount['projet']=$line[6];
                        if(!empty($line[5]))
                            $newAccount['img']=$line[5];
                        $account = Yii::app()->mongodb->startupweekend->findOne(array("_id"=>new MongoId($newAccount["_id"])));
                        if(!$account)
                            Yii::app()->mongodb->startupweekend->insert($newAccount);
                    } 
                    else if( !empty($line[3]) && $line[3]=="projet" )
                    {
                        echo $line[0].' '.$line[1].' '.$line[2].'<br/>';
                        $newAccount = array(
                    			'email'=>$line[2],
                                'created' => $created,
                        		'name' => $line[0].' '.$line[1],
                                'type' => "projet",
                                'country' =>'Réunion',
                                'desc'=> (!empty($line[4])) ? $line[4] : "",
                                'events'=>array(new MongoId("523321c7c073ef2b380a231c"))
                                );
                        Yii::app()->mongodb->group->insert($newAccount);
                        //add a participant
                        $where = array("_id" => new MongoId("523321c7c073ef2b380a231c"));	
                        Yii::app()->mongodb->group->update($where, array('$push' => array("projects"=>$newAccount["_id"])));
                        
                        //add details into statupweekend table
                        $newAccount['type']='projet';
                        if(!empty($line[6]))
                            $newAccount['projet']=$line[6];
                        if(!empty($line[5]))
                            $newAccount['img']=$line[5];
                        Yii::app()->mongodb->startupweekend->insert($newAccount);
                    }
                    else if( !empty($line[3]) && $line[3]=="coach" )
                    {
                        echo $line[0].' '.$line[1].' '.$line[2].'<br/>';
                        $newAccount = array(
                    			'email'=>$line[2],
                                'created' => $created,
                        		'name' => $line[0].' '.$line[1],
                                'type' => "citoyen",
                                'country' =>'Réunion',
                                'events'=>array(new MongoId("523321c7c073ef2b380a231c"))
                                );
                        $account = Yii::app()->mongodb->citoyens->findOne(array("email"=>$line[2]));
                        if($account){
                            Yii::app()->mongodb->citoyens->update(array("_id" => new MongoId($account["_id"])), array('$push' => array("events"=>new MongoId("523321c7c073ef2b380a231c"))));
                            $newAccount["_id"] = $account["_id"];
                        }
                        else
                            Yii::app()->mongodb->citoyens->insert($newAccount);
                        //add a participant
                        $where = array("_id" => new MongoId("523321c7c073ef2b380a231c"));	
                        Yii::app()->mongodb->group->update($where, array('$push' => array("coaches"=>$newAccount["_id"])));
                        
                        //add details into statupweekend table
                        $newAccount['type']='coach';
                        if(!empty($line[5]))
                            $newAccount['img']=$line[5];
                        $account = Yii::app()->mongodb->startupweekend->findOne(array("_id"=>new MongoId($newAccount["_id"])));
                        if(!$account)
                            Yii::app()->mongodb->startupweekend->insert($newAccount);
                    }
                    else if( !empty($line[3]) && $line[3]=="jury" )
                    {
                        echo $line[0].' '.$line[1].' '.$line[2].'<br/>';
                        $newAccount = array(
                    			'email'=>$line[2],
                                'created' => $created,
                        		'name' => $line[0].' '.$line[1],
                                'type' => "citoyen",
                                'country' =>'Réunion',
                                'events'=>array(new MongoId("523321c7c073ef2b380a231c"))
                                );
                        $account = Yii::app()->mongodb->citoyens->findOne(array("email"=>$line[2]));
                        if($account){
                            Yii::app()->mongodb->citoyens->update(array("_id" => new MongoId($account["_id"])), array('$push' => array("events"=>new MongoId("523321c7c073ef2b380a231c"))));
                            $newAccount["_id"] = $account["_id"];
                        }
                        else
                            Yii::app()->mongodb->citoyens->insert($newAccount);
                        //add a participant
                        $where = array("_id" => new MongoId("523321c7c073ef2b380a231c"));	
                        Yii::app()->mongodb->group->update($where, array('$push' => array("jurys"=>$newAccount["_id"])));
                        
                        //add details into statupweekend table
                        $newAccount['type']='jury';
                        if(!empty($line[5]))
                            $newAccount['img']=$line[5];
                        $account = Yii::app()->mongodb->startupweekend->findOne(array("_id"=>new MongoId($newAccount["_id"])));
                        if(!$account)
                            Yii::app()->mongodb->startupweekend->insert($newAccount);
                    }
                    else if( !empty($line[3]) && $line[3]=="organisateur" )
                    {
                        echo $line[0].' '.$line[1].' '.$line[2].'<br/>';
                        $newAccount = array(
                    			'email'=>$line[2],
                                'created' => $created,
                        		'name' => $line[0].' '.$line[1],
                                'type' => "citoyen",
                                'country' =>'Réunion',
                                'events'=>array(new MongoId("523321c7c073ef2b380a231c"))
                                );
                        $account = Yii::app()->mongodb->citoyens->findOne(array("email"=>$line[2]));
                        if($account){
                            Yii::app()->mongodb->citoyens->update(array("_id" => new MongoId($account["_id"])), array('$push' => array("events"=>new MongoId("523321c7c073ef2b380a231c"))));
                            $newAccount["_id"] = $account["_id"];
                        }
                        else
                            Yii::app()->mongodb->citoyens->insert($newAccount);
                        //add a participant
                        $where = array("_id" => new MongoId("523321c7c073ef2b380a231c"));	
                        Yii::app()->mongodb->group->update($where, array('$push' => array("organisateurs"=>$newAccount["_id"])));
                        
                        //add details into statupweekend table
                        $newAccount['type']='organisateur';
                        if(!empty($line[5]))
                            $newAccount['img']=$line[5];
                        $account = Yii::app()->mongodb->startupweekend->findOne(array("_id"=>new MongoId($newAccount["_id"])));
                        if(!$account)
                            Yii::app()->mongodb->startupweekend->insert($newAccount);
                    }
                }
            }
            fclose($handle);
        }
    	?>