function myLv(lv){
	if(lv == '0'){
		return '普通会员';
	}else if(lv == '1'){
		return '县代理';
	}else if(lv == '2'){
		return '市代理';
	}else if(lv == '3'){
		return '省代理';
	}
}
function myNode(node){
	if(node == '0'){
		return '';
	}else if(node == '1'){
		return '铜牌';
	}else if(node == '2'){
		return '银牌';
	}else if(node == '3'){
		return '金牌';
	}else if(node == '4'){
		return '钻石';
	}
}