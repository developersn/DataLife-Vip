<?PHP
if( ! defined('DATALIFEENGINE') ) {
	die( "Hacking attempt!" );
}
  $this_time = time() + ($config['date_adjust'] * 60);
	if ( $member_id['vip_approve'] == 0 ) {
  if ( $doaction == "ok") {
					// Security
					$sec=$_GET['sec'];
					$mdback = md5($sec.'vm');
					$mdurl=$_GET['md'];
					// Security
					if(isset($_GET['sec']) or isset($_GET['md']) AND $mdback == $mdurl )
					{
  
  
					  $orderid = $_GET['order_id'];
					 // $price = $_GET['price'];
					  $resn = $db->super_query("SELECT * FROM ".PREFIX."_vip_sn where id = '$orderid'");
					  $res_plan = $db->super_query("SELECT * FROM ".PREFIX."_vip_panel where id='$resn[vip_panel]'");
					  $MID = $setting_res['marchentid'];
					  $time_end = time()+60*60*24*30*$res_plan['plantme'];
					  $this_time = time() + ($config['date_adjust'] * 60);
					  $price = $resn['price'];
					  $au = $resn['au'];
					  $date_sn = jdate('Y/m/d H:m');
					  $view_endTIME = jdate('Y/m/d', $time_end);
					  
					$setting_res = $db->super_query("SELECT * FROM ".PREFIX."_vip_setting where id = '1'");
	
	
					$bank_return = $_POST + $_GET ;
					$data_string = json_encode(array (
					'pin' => $MID,
					'price' => $price,
					'order_id' => $orderid,
					'au' => $au,
					'bank_return' =>$bank_return,
					));

					$ch = curl_init('https://developerapi.net/api/v1/verify');
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string))
					);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
					$result = curl_exec($ch);
					curl_close($ch);
					$json = json_decode($result,true);
                    										$res=$json['result'];
	                 switch ($res) {
						    case -1:
						    $msg = "پارامترهای ارسالی برای متد مورد نظر ناقص یا خالی هستند . پارمترهای اجباری باید ارسال گردد";
						    break;
						     case -2:
						    $msg = "دسترسی api برای شما مسدود است";
						    break;
						     case -6:
						    $msg = "عدم توانایی اتصال به گیت وی بانک از سمت وبسرویس";
						    break;
						     case -9:
						    $msg = "خطای ناشناخته";
						    break;
						     case -20:
						    $msg = "پین نامعتبر";
						    break;
						     case -21:
						    $msg = "ip نامعتبر";
						    break;
						     case -22:
						    $msg = "مبلغ وارد شده کمتر از حداقل مجاز میباشد";
						    break;
						    case -23:
						    $msg = "مبلغ وارد شده بیشتر از حداکثر مبلغ مجاز هست";
						    break;
						      case -24:
						    $msg = "مبلغ وارد شده نامعتبر";
						    break;
						      case -26:
						    $msg = "درگاه غیرفعال است";
						    break;
						      case -27:
						    $msg = "آی پی مسدود شده است";
						    break;
						      case -28:
						    $msg = "آدرس کال بک نامعتبر است ، احتمال مغایرت با آدرس ثبت شده";
						    break;
						      case -29:
						    $msg = "آدرس کال بک خالی یا نامعتبر است";
						    break;
						      case -30:
						    $msg = "چنین تراکنشی یافت نشد";
						    break;
						      case -31:
						    $msg = "تراکنش ناموفق است";
						    break;
						      case -32:
						    $msg = "مغایرت مبالغ اعلام شده با مبلغ تراکنش";
						    break;
						      case -35:
						    $msg = "شناسه فاکتور اعلامی order_id نامعتبر است";
						    break;
						      case -36:
						    $msg = "پارامترهای برگشتی بانک bank_return نامعتبر است";
						    break;
						        case -38:
						    $msg = "تراکنش برای چندمین بار وریفای شده است";
						    break;
						      case -39:
						    $msg = "تراکنش در حال انجام است";
						    break;
                            case 1:
						    $msg = "پرداخت با موفقیت انجام گردید.";
						    break;
						    default:
						       $msg = $josn['result'];
						}
                    if($json['result'] == 1)
					{
		  $result_payment = "<div class=\"success\">
		  	پرداخت و عضویت VIP شما با موفقیت انجام گردید.
			<br>

			<table width=\"100%\">
				<tr>
				 	<td> پلان انتخابی: </td>
					<td> $res_plan[name] </td>
				</tr>
				<tr>
				 	<td> تاریخ شروع عضویت: </td>
					<td> $date_sn </td>
					<td></td>
				</tr>

				<tr>
				 	<td> تاریخ اتمام عضویت: </td>
					<td> $view_endTIME </td>
				</tr>


				<tr>
				 	<td> مبلغ واریزی :  </td>
					<td> $resn[price] </td>
				</tr>


			</table>

		  </div>";



  	$db->query( "UPDATE " . PREFIX . "_vip_sn set `au`='".$au."',`res`='".$au."', `date`='".$date_sn."', `vip_time`='".$time_end."', `show`='1' where userid='$member_id[user_id]'  limit 1");
	
	$db->query( "UPDATE " . PREFIX . "_users set `viptime_plan`='".$time_end."', `viptime_start`='".$this_time."' where user_id='$member_id[user_id]' limit 1");

	$db->query( "UPDATE " . PREFIX . "_users set `user_group`='".$setting_res['group_id']."' where user_id='$member_id[user_id]' limit 1");



	  } else {
		$result_payment = "  <div class=\"success\">
			خطا در پرداخت :  &nbsp;&nbsp; $msg
			<br>
			لطفا مجددا تلاش نمایید.

		  </div>";


	  }
 } else {
		$result_payment = "  <div class=\"success\">
			خطا در پرداخت :  &nbsp;&nbsp; $msg
			<br>
			لطفا مجددا تلاش نمایید.

		  </div>";


	  }





	$tpl->set( '{result}', $result_payment);
	$tpl->load_template( 'vip_success.tpl' );
	$tpl->compile( 'content' );
	$tpl->clear();



  } elseif ( $doaction == "payment" ) {

	  	if ( empty( $_POST['vipradio'])) {
			msgbox("خطا !"," گزینه ای برای پرداخت انتخاب نشده است.");
		} else {
		$id = intval($_POST['vipradio']);

	  	$select_row = $db->super_query("SELECT * FROM ".PREFIX."_vip_panel where id = '$id' limit 1");
	  	$setting_res = $db->super_query("SELECT * FROM ".PREFIX."_vip_setting where id = '1'");

	  
	  $MID = $setting_res['marchentid'];
	  	  $webservice = $setting_res['webservice'];
	  $price = $select_row['price'];
	  	  $db->query( "INSERT INTO " . PREFIX . "_vip_sn set `userid`='".$member_id['user_id']."', `vip_panel`='".$id."', `au` = '".$res."', `price`='".$price."', `show`='0'");
          $insert_id = $db->insert_id();
          $GLOBALS["RedirectURL"] = "".$config['http_home_url']."index.php?do=vip_user&doaction=ok&price=". $select_row['price']."&order_id=". $insert_id."";
					// Security
					@session_start();
					$sec = uniqid();
					$md = md5($sec.'vm');
					// Security          
							
			$callBackUrl = $GLOBALS["RedirectURL"]."&sec=".$sec."&md=".$md;
		
					$data_string = json_encode(array(
					'pin'=> $MID,
					'price'=> $price,
					'callback'=> $callBackUrl ,
					'order_id'=> $insert_id,
					'ip'=> $_SERVER['REMOTE_ADDR'],
					'callback_type'=>2
					));

					$ch = curl_init('https://developerapi.net/api/v1/request');
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string))
					);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
					$result = curl_exec($ch);
					curl_close($ch);


					$json = json_decode($result,true);
															$res=$json['result'];
	                 switch ($res) {
						    case -1:
						    $msg = "پارامترهای ارسالی برای متد مورد نظر ناقص یا خالی هستند . پارمترهای اجباری باید ارسال گردد";
						    break;
						     case -2:
						    $msg = "دسترسی api برای شما مسدود است";
						    break;
						     case -6:
						    $msg = "عدم توانایی اتصال به گیت وی بانک از سمت وبسرویس";
						    break;
						     case -9:
						    $msg = "خطای ناشناخته";
						    break;
						     case -20:
						    $msg = "پین نامعتبر";
						    break;
						     case -21:
						    $msg = "ip نامعتبر";
						    break;
						     case -22:
						    $msg = "مبلغ وارد شده کمتر از حداقل مجاز میباشد";
						    break;
						    case -23:
						    $msg = "مبلغ وارد شده بیشتر از حداکثر مبلغ مجاز هست";
						    break;
						      case -24:
						    $msg = "مبلغ وارد شده نامعتبر";
						    break;
						      case -26:
						    $msg = "درگاه غیرفعال است";
						    break;
						      case -27:
						    $msg = "آی پی مسدود شده است";
						    break;
						      case -28:
						    $msg = "آدرس کال بک نامعتبر است ، احتمال مغایرت با آدرس ثبت شده";
						    break;
						      case -29:
						    $msg = "آدرس کال بک خالی یا نامعتبر است";
						    break;
						      case -30:
						    $msg = "چنین تراکنشی یافت نشد";
						    break;
						      case -31:
						    $msg = "تراکنش ناموفق است";
						    break;
						      case -32:
						    $msg = "مغایرت مبالغ اعلام شده با مبلغ تراکنش";
						    break;
						      case -35:
						    $msg = "شناسه فاکتور اعلامی order_id نامعتبر است";
						    break;
						      case -36:
						    $msg = "پارامترهای برگشتی بانک bank_return نامعتبر است";
						    break;
						        case -38:
						    $msg = "تراکنش برای چندمین بار وریفای شده است";
						    break;
						      case -39:
						    $msg = "تراکنش در حال انجام است";
						    break;
                            case 1:
						    $msg = "پرداخت با موفقیت انجام گردید.";
						    break;
						    default:
						       $msg = $josn['result'];
						}
					if(!empty($json['result']) AND $json['result'] == 1)
					{
						// Set Session
					$_SESSION[$sec] = [
						'price'=>$amount ,
						'order_id'=>$invoice_id ,
						'au'=>$json['au'] ,
					]; 
	 
 $db->query( "UPDATE " . PREFIX . "_vip_sn set `au`='".$json['au']."' where id='$insert_id'  limit 1 ");
            echo ('<div style="display:none">'.$json['form'].'</div>Please wait ... <script language="javascript">document.payment.submit(); </script>');
	      } else {
              
                    		msgbox("خطا !"," خطا در اتصال به درگاه".$msg);

                }



	  echo '
	
	';


		}


  } else {


    $query = $db->query("SELECT * FROM ".PREFIX."_vip_panel order by id desc");
	while ( $row = $db->get_row($query))  {
		$price = number_format($row['price']);
		$list_panel .= "<label for=\"da$row[id]\"><li><input type=\"radio\" id='da$row[id]' name=\"vipradio\" value=\"".$row['id']."\"> $row[name] &nbsp; $price تومان </li>";

	}


	$ON_FORM = "<form method=\"post\" action=\"".$config['http_home_url']."index.php?do=vip_user&doaction=payment\" enctype=\"multipart/form-data\">";  
	$END_FORM = "</form>"; 

    $tpl->set( '{payerror}', $payerror);
	$tpl->set( '{form start}', $ON_FORM);
	$tpl->set( '{end form}', $END_FORM);
	$tpl->set( '{لیست پنل‏ها}', $list_panel);
	$tpl->load_template( 'vip_user.tpl' );
	$tpl->compile( 'content' );
	$tpl->clear();
  }
  } else {
  msgbox("خطا", "شما عضو VIP بوده و قادر به پرداخت و عضويت VIP مجدد نميباشيد. در صورت هرگونه مشکل با مديريت تماس حاصل نماييد."
  );
  }

?>