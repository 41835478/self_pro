<?php if(!defined('PROJECT_NAME')) die('project empty');?>
<form action="" method="post" enctype="multipart/form-data">
<br>请输入商铺名称:<input type="text" name="store_name" placeholder="请输入商铺名称">
<br>商铺简述:<input type="text" name="store_title" placeholder="简单描述">
<br>真实姓名:<input type="text" name="true_name" placeholder="真实姓名">
<br>手机号:<input type="text" name="phone" placeholder="手机号">
<br>身份证号:<input type="text" name="card_id" placeholder="身份证号">
<br>商铺logo:<input type="file" name="store_logo" >
<br>商铺地址:<input type="text" name="store_address" >
<br>商铺详细地址:<input type="text" name="store_xx_address" >
<br>身份证正面:<input type="file" name="card_z" >
<br>身份证反面:<input type="file" name="card_f" >
<br>背景图片:<input type="file" name="store_background" >
<br>营业执照（1）:<input type="file" name="store_imgs[]" >
<br>营业执照（2）:<input type="file" name="store_imgs[]" >
<br>营业执照（3）:<input type="file" name="store_imgs[]" >
<br>商铺说明:<textarea name="store_desc"></textarea>
<br><input type="submit" value="入驻">
</form>
</body>
</html>
