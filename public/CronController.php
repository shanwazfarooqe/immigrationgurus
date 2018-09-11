<?php
/***************************************************************************
 *                                                                          *
 *                                                                          *
 * This  is  commercial  software,  only  users  who have purchased a valid *
 * license  and  accept  to the terms of the  License Agreement can install *
 * and use this program.                                                    *
 *                                                                          *
 ****************************************************************************
 * PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
 * "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
 ****************************************************************************/
//
//$Id: CronController.php, v2.0 2017/06/14 20:52:11
//
class CronController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		if($this->getSettingValue('security_settings', 'cron_execution_ip_restriction')=='Yes')
			$this->checkPermission();
	}

    //Update tickets using imap functions
	public function updateticketsAction()
    {                            
		$ObjCustomerService       =  new CustomerServiceModel();   
        $ObjWebsite  	    	  =  new WebsiteModel();
        $ObjSettings              =  new SettingsModel();
        $ObjStores                =  new StoresModel();
        $ObjEmailtemplate         =  new EmailtemplateModel();
        $language_ids   = $this->ObjView->language_ids; 
                                       
        $WebsiteDet = '';
		$params =   array(
                   'settingsGroupKey'  =>  'customer_support'
                  // 'website_id'        =>  $WebsiteDet['website_id']
               );
        $CustomerSettings   =   $ObjSettings->getSettingsValueByScope($params);
            
       if($CustomerSettings['enable_imap_reading']=='Yes') 
       {
            $hostname = $CustomerSettings['host'];
            $username = $CustomerSettings['email_address'];
            $password = $CustomerSettings['password'];

            /* try to connect */
            $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to mail: ' . imap_last_error());

              /* if emails are returned, cycle through each... */ // Search UNANSWERED flags 
             $emails = imap_search($inbox,'UNSEEN'); 
               if($emails) {
                  /* put the newest emails on top */ 
                       sort($emails); 
                  /* for every email... */
                  foreach($emails as $email_number) {
                
                    $headers =array(); 
                    /* get information specific to this email */ 
					//  $message = quoted_printable_decode(imap_fetchbody($inbox,$email_number,1));   
                      $headers=  $this->mail_header_parse($inbox,$email_number);	
                      $headerinfo =  imap_headerinfo ($inbox, $email_number); 					   		  
                      $structure = imap_fetchstructure($inbox,$email_number);

					   $message = $this->get_part($inbox, $email_number, "TEXT/HTML");

						if ($message == "") {
							$message = $this->get_part($inbox, $email_number, "TEXT/PLAIN");
						}
						$message	= strip_tags($message); 
						
                       $date =  date('Y-m-d H:i:s',$headerinfo->udate);  

                       $from             =  	explode('<',$headers['From']);
					   $toEmail				=	explode('<',$headers['to']);
                       $headersFrom      =  str_replace('>','',$from[1]);

                       $fullname         =  explode(' ',$from[0]);
					   $ReplySubject    =  	trim($headerinfo->Subject); 
					   $TicketIDSplit	= 	explode("-", $ReplySubject);
					   $TicketID		=	$TicketIDSplit[1];
					   
                       $POST['contact_first_name']   = $fullname[0];
                       $POST['contact_last_name']    = $fullname[1];
                       $POST['userEmail']            = $headerinfo->from[0]->mailbox . "@" . $headerinfo->from[0]->host; 
					   $toEmail				         = $headerinfo->to[0]->mailbox . "@" . $headerinfo->to[0]->host; 
                       $POST['ticket_subject']       = $headerinfo->Subject;  
                       $POST['ticket_message']       = $message;
                       $POST['date']                 = $date;
                       $POST['imap']                 = 1;
                       $attach                       = 1;
                        //Save attachments
                                $attachments = array();
                                   if(isset($structure->parts) && count($structure->parts)) { 
                                      for($i = 0; $i < count($structure->parts); $i++) {
                                          if($structure->parts[$i]->disposition == "ATTACHMENT") {  
                                          $attachments[$i] = array(
                                             'is_attachment' => false,
                                             'filename' => '',
                                             'name' => '',
                                             'attachment' => '');
                            
                                          if($structure->parts[$i]->ifdparameters) {
                                             
                                            foreach($structure->parts[$i]->dparameters as $object) {
                                              if(strtolower($object->attribute) == 'filename') {
                                                $attachments[$i]['is_attachment'] = true;
                                                $attachments[$i]['filename'] = $object->value;
                                              }
                                            }
                                          }

                                          if($structure->parts[$i]->ifparameters) {
                                                
                                            foreach($structure->parts[$i]->parameters as $object) {
                                              if(strtolower($object->attribute) == 'name') {
                                                $attachments[$i]['is_attachment'] = true;
                                                $attachments[$i]['name'] = $object->value;
                                              }
                                            }
                                          }

                                          if($attachments[$i]['is_attachment']) {
                                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                                            if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                                              $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                                            }
                                            elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                                              $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                                            }
                                          }             
                                        }  
                                     }
                                 }  
                                    
                                   if(count($attachments)!=0){
                                       foreach($attachments as $at){
                                           if($at['is_attachment']==1){ 
                                               $Upname                                 =  rand(). trim(str_replace(" ","_", $at['filename'])) ;
                                                $POST['ticket_fileName']		 =  $Upname; 
                                                 file_put_contents($POST['ticket_fileName'], $at['attachment']);
                                                $POST['ticket_filetemppath'] = $POST['ticket_fileName'];
                                               }
                                               break; //new code
                                           }
                                    }
                                  
						$getStore_id	=	$ObjCustomerService->getDefaultStoreForImap($toEmail); 

						$store_id	=	$getStore_id[0]['store_id'];
                        if($userID=='' || empty($userID)){  //automaticaly assign
                                 $userDet  = $ObjCustomerService->getUserInfoByemail($POST['userEmail'],"Active",$store_id);
                                 $POST['userID']   = $userDet['userID'];
                        }

                       $mailreadStatus = 0; 
                        $siteUrl                        =    $this->ObjCommon->site_url; 
						$siteUrl                        = 	rtrim($siteUrl,"/");
                       if(empty($TicketID))  // New ticket
                       {
                               $POST['department_id']        =  $ObjCustomerService->selectDept('A'); //select default department
                               $POST['store_id']             =  $store_id;
                               $POST['created_by_user']      =  'User';  
                               $ticketID                     = $ObjCustomerService->saveTicket($POST); 
                               $mailreadStatus = 1;
                               //Save history                                                              
                               $params = array(
                                        'ticket_id'       => $ticketID, 
                                        'user_type'       => 'customer', 
                                        'user_value'      => $POST['contact_first_name']." ".$POST['contact_last_name'].":".$userID,
                                        'action_type1'     => 'New_Ticket',  
                                        'changed_feild1'   => '', 
                                        'old_value1'       => '', 
                                        'new_value1'       => ''
                                          );
                              $ObjCustomerService->saveHistory($params);
                             
                               //customer notification mail
                                     $params=array('store_id'          => $store_id,
                                      'field'             => 'website_id,website_name', 
                                      'multiplefields'    => 'yes'
                                      );
                                    $website_Det                    =    $ObjStores->getWebsiteFieldByStore($params);   
                                    $website_id                     =    $website_Det['website_id'];
                                    $website_name                   =    $website_Det['website_name'];

                                    // User Notification For Ticket Aknowlwdge
                                    $emailbody                     =    $ObjEmailtemplate->getEmailTemlateDetails('ticket-notification-customer',$website_id,$store_id);
                                    
                                    $language_idsCustom            =    $language_ids;
                                    $language_idsCustom['Current'] =    $language_ids['Default']; 
                                    $mailSettings                  =    $this->getSettingValue('mail_settings');
                                    $ObjMail                       =    new Mail($mailSettings);
                                    $paramss=array('store_id'=>$store_id,
                                       'ticket_id'=>$ticketID,
                                       'language_ids'=>$language_ids,
                                       'userdet'=>'Yes',
                                       'deptUserList'=>'Yes');
                                    $results                       =    $ObjCustomerService->getTicket($paramss);
                                    $ticketDet                     =    $results['tickets'];
                                    $deptUserList                  =    $results['deptUserList'];
									$ticket_identification_id      =    $ticketDet['ticket_identification_id'];
                                    $subject                       =   $website_name."-".$ticketDet['ticket_identification_id']."-".$POST['ticket_subject'];
									$from      = array(
                                                     $toEmail,
                                                     $emailbody['emailFromName'],
                                                     $ticket_identification_id
                                             );
                                    $body                          =   $emailbody['emailHtml'];
                                    $ticketIdeID                   =   $this->encodeString($ticketDet['ticket_id']);
                                    $ticID                         =  $ticketDet['ticket_id'];
                                    $ticFile                       =  ''; 
                                    if($ticketDet['customer_id'] <= 0)
                                            { 
                                                $siteUrl                        =   $siteUrl.'/customerservice/custicket/id/'.$ticketIdeID.'/';
                                                $links                          =   " <a href='".$siteUrl."'>".$this->getLanguageValue("lblClickHere")."</a>";
                                                $body                           =   str_replace('{$Url}',$links,$body);
                                                 if($ticFile){
                                                    $dsiteUrl                       =    $this->ObjCommon->site_url;
													$dsiteUrl                       = 	rtrim($dsiteUrl,"/");
                                                    $downloadsiteUrl= $dsiteUrl.'/customerservice/download/name/'.$ticFile.'/';
                                                      $links                          =   " <a href='".$downloadsiteUrl."'>".$this->getLanguageValue("lblAttachClickHere")."</a>";
                                                    $body                           =   str_replace('{$downloadlink}',$links,$body);
                                                 }else{

                                                     $body                           =   str_replace('{$downloadlink}','',$body);
                                                 }
                                            }else{ 
                                                 $siteUrl                        =    $siteUrl.'/customerservice/custicket/id/'.$ticketIdeID.'/';
                                                $links                          =   " <a href='".$siteUrl."'>".$this->getLanguageValue("lblClickHere")."</a>";
                                                 $body                           =   str_replace('{$Url}',$links,$body);
                                                 if($ticFile){
                                                    $dsiteUrl                       =    $this->ObjCommon->site_url;
													$dsiteUrl                       = 	rtrim($dsiteUrl,"/");
                                                    $downloadsiteUrl= $dsiteUrl.'/user/download/name/'.$ticFile.'/';
                                                      $links                          =   " <a href='".$downloadsiteUrl."'>".$this->getLanguageValue("lblAttachClickHere")."</a>";
                                                    $body                           =   str_replace('{$downloadlink}',$links,$body);
                                                 }
                                                 else{

                                                     $body                           =   str_replace('{$downloadlink}','',$body);
                                                 }
                                            } 
                                    $body                          =    str_replace('{$ticketID}',$ticketDet['ticket_identification_id'],$body);
                                    $body                          =    str_replace('{$subject}',$POST['ticket_subject'],$body);
                                    $body                          =    str_replace('{$category}',$ticketDet['department_name'],$body);
                                    $body                          =    str_replace('{$status}',$ticketDet['ticket_status_title'],$body);
                                    $body                          =    str_replace('{$siteUrl}',$siteUrl,$body);
                                    $body                          =    str_replace('{$details}',$POST['ticket_message'],$body); 
                                    $body                          =    str_replace('{$userName}',$POST['contact_first_name'],$body); 
                                    if(!empty($POST['masterOrderID'])){ 
                                         $body                          =    str_replace('{$order}',$POST['masterOrderID'],$body); 
                                    }else{ 
                                         $body                          =    str_replace('{$order}','',$body); 
                                          $body = $this->get_string_between($body, '<!--order-->', '<!--order-end-->');
                                    }  
                                    $body = str_replace('<!--order-->', '', $body);
                                    $body = str_replace('<!--order-end-->', '', $body);

                                    if($POST['contact_phoneNumberNew'])
                                    {
                                     $body                          =    str_replace('{$phone}',$POST['contact_phoneNumberNew'],$body);   
                                    }  else {
                                     $body = $this->get_string_between($body, '<!--phone-->', '<!--phone-end-->');
                                    }
                                    $body = str_replace('<!--phone-->', '', $body);
                                    $body = str_replace('<!--phone-end-->', '', $body);  
                                    
                                    $body1                         =    $this->ObjCommon->setCommonEmailLayout($body,$website_id,$store_id); 
                                    
                                    $emailID                       =    $POST['userEmail'];
                                    $subject                        =   $emailbody['emailSubject'];   
                                    $subject                       =   str_replace('{$websitname}',$website_name,$subject);
                                    $subject                       =   str_replace('{$ticketid}',$ticketDet['ticket_identification_id'],$subject);
                                    $subject                       =   str_replace('{$subject_title}',$POST['ticket_subject'],$subject); 
                                    $ObjMail->clearAddresses();
                                    $ObjMail->IsHTML();
                                    $ObjMail->sendMail($from, $emailID, $subject, $body1); 
                                    if ($ObjMail->Send())
                                    {      
                                    }      
                               //End customer notification mail
                              
                       }else{
                          $TickDet                                =   $ObjCustomerService->getTicketByuniqueID($TicketID);
                          if($TickDet){
                              $POST['userID']	                     =	$TickDet['customer_id']; 
                              $POST['ticket_created_user_type']    =	'User'; 
                              $POST['ticket_id']	             =	$TickDet['ticket_id']; 
                              $POST['ticket_status_id']            =   '8'; // For response status 
                              $ticketDetailsID          = $ObjCustomerService->replayTicket($POST);
                              $mailreadStatus = 1;
                              //History saving
                              $action_type1    = 'Reply';
                              $changed_feild1  = '';
                              $old_value1      = '';
                              $new_value1      = '';
                              if($POST['ticket_status_id'] != $TickDet['ticket_status_id'])
                              {
                                  $changed_feild2  = ($POST['ticket_status_id']!='')?'Status':'';
                                  $action_type2    = ($POST['ticket_status_id']!='')?'Value_Change':'';  
                                   $params = array(
                                                  'field'        => 'status',
                                                  'language_ids' => $language_ids['Current'],
                                                  'status_old'   => $TickDet['ticket_status_id'],
                                                  'status_new'   => $POST['ticket_status_id']
                                                  );
                                  $paramNames = $ObjCustomerService->getNameByID($params);

                                  $old_value2 =  $paramNames['0']['ticket_status_title'];
                                  $new_value2 =  $paramNames['1']['ticket_status_title'];
                              }

                              $params = array(
                                        'ticket_id'         => $TickDet['ticket_id'], 
                                        'user_type'         => 'customer', 
                                        'user_value'        => $POST['contact_first_name']." ".$POST['contact_last_name'].":".$userID,
                                        'action_type1'      => $action_type1,  
                                        'changed_feild1'    => $changed_feild1, 
                                        'old_value1'        => $old_value1, 
                                        'new_value1'        => $new_value1,
                                        'action_type2'      => $action_type2,  
                                        'changed_feild2'    => $changed_feild2, 
                                        'old_value2'        => $old_value2, 
                                        'new_value2'        => $new_value2
                                          );
                              $ObjCustomerService->saveHistory($params);
                          }

                       } 

                            
                  }

             }
        }
	} 
	function get_part($inbox, $email_number, $mimetype, $structure = false, $partNumber = false) {
		if (!$structure) {
			$structure = imap_fetchstructure($inbox, $email_number);
		}
		if ($structure) {
			if ($mimetype == $this->get_mime_type($structure)) {
				if (!$partNumber) {
					$partNumber = 1;
				}
				$text = imap_fetchbody($inbox, $email_number, $partNumber);
				switch ($structure->encoding) {
				case 3: return imap_base64($text);
				case 4: return imap_qprint($text);
				default: return $text;
				}
			}

			// multipart 
			if ($structure->type == 1) {
				foreach ($structure->parts as $index => $subStruct) {
					$prefix = "";
					if ($partNumber) {
						$prefix = $partNumber . ".";
					}
					$data = $this->get_part($inbox, $email_number, $mimetype, $subStruct, $prefix . ($index + 1));
						if ($data) {
							return $data;
						}
				}
			}
		}
	}
						
	function get_mime_type($structure) {
		$primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

		if ($structure->subtype) {
			return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
		}
	return "TEXT/PLAIN";
	}
	
	function mail_header_parse($mbox,$msg){
		error_reporting(0); 
		$header=imap_fetchheader($mbox,$msg);
		preg_match_all("/^([^\r\n:]+)\s*[:]\s*([^\r\n:]+(?:[\r]?[\n][ \t][^\r\n]+)*)/m",$header,$matches,PREG_SET_ORDER);
		foreach($matches as $match){
			$match[2]=iconv_mime_decode($match[2],ICONV_MIME_DECODE_CONTINUE_ON_ERROR,'utf-8');
			if(is_array($headers[$match[1]])){
				$headers[$match[1]][]=$match[2];
			}elseif(isset($headers[$match[1]])){
				$headers[$match[1]]=array($headers[$match[1]],$match[2]);
			}else{
				$headers[$match[1]]=$match[2];
			}
		}
		return $headers;
	}
	
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		//substr($string,$ini,$len); 
		$result = str_replace(substr($string,$ini,$len), '', $string);
		$result = str_replace($start, '', $result);
		$result = str_replace($end, '', $result);
		return $result;     
	}
}