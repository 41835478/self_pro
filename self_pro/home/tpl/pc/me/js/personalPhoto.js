/**
 * Created by developer on 2017/10/16.
 */
$(function () {
    var baseurl = "http://www.125898.com";
    var userModel = JSON.parse(sessionStorage.userModel);

    //返回上个页面
    $(".left_img").click(function () {
        window.history.back(-1);
    });

    // var imagesArr = userModel.images.split(",");
    // if (imagesArr.length == 1) {
    //     document.getElementById("pic1").src = baseurl + imagesArr[0];
    //     $("#pic1-div .delete").css('display', 'block');
    //     $("#pic2-div").css('display','block');
    // } else if(imagesArr.length == 2) {
    //     document.getElementById("pic1").src = baseurl + imagesArr[0];
    //     $("#pic1-div .delete").css('display', 'block');
    //     $("#pic2-div").css('display','block');
    //     document.getElementById("pic2").src = baseurl + imagesArr[1];
    //     $("#pic2-div .delete").css('display', 'block');
    //     $("#pic3-div").css('display','block');
    // } else if(imagesArr.length == 3) {
    //     document.getElementById("pic1").src = baseurl + imagesArr[0];
    //     $("#pic1-div .delete").css('display', 'block');
    //     $("#pic2-div").css('display','block');
    //     document.getElementById("pic2").src = baseurl + imagesArr[1];
    //     $("#pic2-div .delete").css('display', 'block');
    //     $("#pic3-div").css('display','block');
    //     document.getElementById("pic3").src = baseurl + imagesArr[2];
    //     $("#pic3-div .delete").css('display', 'block');
    //     $("#pic4-div").css('display','block');
    // }

    var picArr = new Array();
    //选择资源图片
    var fileInput1 = document.getElementById("upfile1");
    var fileImage1 = document.getElementById("pic1");
    //监听change事件
    fileInput1.addEventListener('change',function(){
        //清空预览区背景图片
        // fileImage1.src = '';
        //获取file的引用
        var file = fileInput1.files[0];
        //读取文件
        var reader = new FileReader();
        reader.onload = function(e){
            var data = e.target.result;
            picArr[0] = data;
            fileImage1.src = data;
            $("#pic1-div .delete").css('display', 'block');
            $("#pic2-div").css('display','block');
        }
        // 以DataURL的形式读取文件:
        reader.readAsDataURL(file);
        console.log(file);
    });
    $("#pic1").click(function() {
        fileInput1.click();
    });

    var fileInput2 = document.getElementById("upfile2");
    var fileImage2= document.getElementById("pic2");
    //监听change事件
    fileInput2.addEventListener('change',function(){
        //清空预览区背景图片
        // fileImage1.src = '';
        //获取file的引用
        var file = fileInput2.files[0];
        //读取文件
        var reader = new FileReader();
        reader.onload = function(e){
            var data = e.target.result;
            picArr[1] = data;
            fileImage2.src = data;
            $("#pic2-div .delete").css('display', 'block');
            $("#pic3-div").css('display','block');
        }
        // 以DataURL的形式读取文件:
        reader.readAsDataURL(file);
        console.log(file);
    });
    $("#pic2").click(function() {
        fileInput2.click();
    });

    var fileInput3 = document.getElementById("upfile3");
    var fileImage3= document.getElementById("pic3");
    //监听change事件
    fileInput3.addEventListener('change',function(){
        //清空预览区背景图片
        // fileImage1.src = '';
        //获取file的引用
        var file = fileInput3.files[0];
        //读取文件
        var reader = new FileReader();
        reader.onload = function(e){
            var data = e.target.result;
            picArr[2] = data;
            fileImage3.src = data;
            $("#pic3-div .delete").css('display', 'block');
            $("#pic4-div").css('display','block');
        }
        // 以DataURL的形式读取文件:
        reader.readAsDataURL(file);
        console.log(file);
    });
    $("#pic3").click(function() {
        fileInput3.click();
    });



    // 左上角按钮删除图片
    $(".delete").click(function () {
        var ver = $(this).parent().attr('id');
        var index = ver.substr(3,1);
        switch(parseInt(index)) {
            case 1: {
                $("#pic1").attr('src','img/imgSelectBtn.png');
                $("#pic1-div .delete").css('display', 'none');
                $("#pic2-div").css('display','none');
                break;
            }
            case 2: {
                $("#pic2").attr('src','img/imgSelectBtn.png');
                $("#pic2-div .delete").css('display', 'none');
                $("#pic3-div").css('display','none');
                break;
            }
            case 3: {
                $("#pic3").attr('src','img/imgSelectBtn.png');
                $("#pic3-div .delete").css('display', 'none');
                $("#pic4-div").css('display','none');
                break;
            }
        }
    });

//保存个人照片
    $(".sendBtn").click(function () {
        if (picArr.length < 1) {
            alert("请选择个人照片");
        }  else {
            console.log(userModel.userId,userModel.sign,picArr);
            $.ajax({
                type:'POST',
                url:baseurl + '/api/api.php?commend=user_images',
                dataType: 'json',
                data: {u_id:userModel.userId,sign:userModel.sign,
                        images:picArr,debug:"true"},
                success:function (data) {
                    console.log(data);

                }
            });
        }
    });
});


