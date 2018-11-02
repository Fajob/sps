<?php
require_once(ROOT_PATH."/common/UploadFile.php");
class imageModule
{

	private $UploadFile;	
	public function deal_image()
	{
		$allow_type = array("jpg","png","jpeg");
		$this->UploadFile = new UploadFile(true,ROOT_PATH."/public/images/",$allow_type);
		$request_data = $GLOBALS['request_data'];
		$id = $GLOBALS['request_data']['id'];
		$file = $_FILES['file'];
		if($this->UploadFile->upload_file($file))
		{
			$file_path = "public/images/".$this->UploadFile->get_file_name();
			#保存图片链接到数据库


			$sql = "update ".DB_PREFIX."deal set img=".'"'.$file_path.'"  where id='.$id;
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


	public function  save_base64_image($image)
	{
		$imageName = "25220_".date("His",time())."_".rand(1111,9999).'.png';
		$file_path = "public/images/".$imageName;
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
