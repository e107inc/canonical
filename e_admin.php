<?php


//v2.x Standard for extending admin areas.


class canonical_admin
{
	private $active = false;


	function __construct()
	{
		// $pref = e107::pref('core','trackbackEnabled');
		$this->active = 1;
	}


	/**
	 * Extend Admin-ui Parameters
	 * @param $ui admin-ui object
	 * @return array
	 */
	public function config($ui)
	{
		$action     = $ui->getAction(); // current mode: create, edit, list
		$type       = $ui->getEventName(); // 'wmessage', 'news' etc.
		$id         = $ui->getId();
		$sql        = e107::getDb();

		$config = array();

		switch($type)
		{
			case "news":


				if(!empty($id) && ( $url = $sql->retrieve("canonical","can_url", "can_table='news' AND can_pid=".$id)))
				{
					$default = $url;
				}
				else
				{
					$default = '';
				}


				if($this->active == true)
				{
					$config['fields']['url'] =   array ( 'title' =>"Canonical URL", 'type' => 'url', 'tab'=>1,  'writeParms'=> array('size'=>'xxlarge', 'placeholder'=>'', 'default'=>$default), 'width' => 'auto', 'help' => '', 'readParms' => '', 'class' => 'left', 'thclass' => 'left',  );
				}
				break;
		}

		//Note: 'urls' will be returned as $_POST['x_canonical_url']. ie. x_{PLUGIN_FOLDER}_{YOURKEY}

		return $config;

	}


	/**
	 * Process Posted Data.
	 * @param $ui admin-ui object
	 */
	public function process($ui, $id=0)
	{

		$data       = $ui->getPosted();
		$type       = $ui->getEventName();
		$action     = $ui->getAction(); // current mode: create, edit, list

		$sql = e107::getDb();

	//	e107::getMessage()->addDebug("Object: ".print_a($ui,true));
	//	e107::getMessage()->addInfo("ID: ".$id);
	//	e107::getMessage()->addInfo("Action: ".$action);
	//	e107::getMessage()->addInfo(print_a($data,true));

		if($action == 'delete')
		{
			return;
		}

		if(e_LANGUAGE != 'English')
		{
			return;
		}

		if(!empty($id) && $this->active)
		{

			if(!empty($data['x_canonical_url']))
			{

				if(!$sql->update("canonical", "can_url='".$data['x_canonical_url']."' WHERE can_pid= ".$id))
				{
					$insert = array("can_id"=>0, "can_pid"=> $id, "can_table"=>$type, 'can_title'=>$data['news_title'],'can_url'=>$data['x_canonical_url']);

					if($sql->insert("canonical", $insert))
					{
						e107::getMessage()->addDebug(print_a($insert,true));
					}
					else
					{
						e107::getMessage()->addError("Couldn't update Canonical URL");
					}
				}
				else
				{
					e107::getMessage()->addInfo("Updated Canonical URL");
				}

			}


		}



	}



}




?>