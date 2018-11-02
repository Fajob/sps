<?php
require_once(ROOT_PATH."/common/UploadFile.php");
class imageModule
{

	private $UploadFile;	
	public function user_avastar()
	{
		$allow_type = array("jpg","png","jpeg");
		$this->UploadFile = new UploadFile(true,ROOT_PATH."/public/img/avastar/",$allow_type);
		$request_data = $GLOBALS['request_data'];
		$id = $GLOBALS['request_data']['id'];
		if(isset($_FILES['file']))
		{
			$file = $_FILES['file'];
			if($this->UploadFile->upload_file($file))
			{
				$file_path = "public/img/avastar/".$this->UploadFile->get_file_name();
				#保存图片链接到数据库


				$sql = "update ".DB_PREFIX."user set user_avatar=".'"'.$file_path.'"  where id='.$id;
				if($GLOBALS['db']->query($sql))
				{
					$result = array("status" => true,"msg"=> "上传成功！");
					echo json_encode($result);
					exit(0);
				}
				else
				{
					$result = array("status" => false,"msg"=>"上传失败！");
					echo json_encode($result);
				}

			}
			else
			{
				#上传失败
				$result = array("status" => false,"msg"=> $this->UploadFile->get_msg());
				echo json_encode($result);
			}
		}
		if(isset($request_data['image']))
		{
			$image = $request_data['image'];
			$file_path = $this->save_base64_image($image);
			$sql = "update ".DB_PREFIX."user set user_avatar=".'"'.$file_path.'"  where id='.$id;
			if($GLOBALS['db']->query($sql))
			{
				$result = array("status" => true,"msg"=> "上传成功！");
				echo json_encode($result);
				exit(0);
			}
			else
			{
				$result = array("status" => false,"msg"=>"上传失败！");
				echo json_encode($result);
			}
		
		}
	}


	public function  save_base64_image($image)
	{
		$imageName = "25220_".date("His",time())."_".rand(1111,9999).'.png';
		$file_path = "/public/img/avastar/".$imageName;
		if (strstr($image,","))
		{
			$image = explode(',',$image);
			$image = $image[1];
		}
		file_put_contents(ROOT_PATH .$file_path, base64_decode($image));
		return $file_path;
			
	}





}



?>
