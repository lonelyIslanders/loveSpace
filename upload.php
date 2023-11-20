<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set("Asia/Shanghai");
session_start();
if (!$_SESSION['lsp']) {
    echo "<script>alert('请先登陆！');window.location.href='login.html';</script>";
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <title>图片上传</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vant@2.2/lib/index.css">
    <script src="https://cdn.suoluomei.com/common/js2.0/vue/v2.5.16/vue.js"></script>
    <script src="https://cdn.suoluomei.com/common/js2.0/npm/vant@2.2/lib/vant.min.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.19.0-beta.1/axios.min.js"></script>
    <script src="https://yourk.top/js/sweetalert.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        button {
            background-color: #f2d547;
            border-radius: 5px;
            display: inline-block;
            padding: 10px;
        }

        button:hover {
            background-color: royalblue;
        }
    </style>
</head>

<?php
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
if (!empty($_FILES['file'])) {
    $connect = mysqli_connect("localhost", "root", "wpj408123.", "images");
    mysqli_set_charset($connect, "utf8");
    if ($connect) {
        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            echo "<script>confirm('非正常上传！');window.location.href='index.php';</script>";
            exit;
        }

        // $max_size = 30 * 1024 * 1024;
        // if ($_FILES['file']['size'] > $max_size) {
        //     echo "<script>confirm('文件超过30M！');window.location.href='index.php';</script>";
        //     exit;
        // }

        $end_name = $_FILES['file']['name'];
        $ext = end(explode('.', $end_name));
        $types = ['png', 'jpg', 'jpeg', 'gif'];
        if (!in_array($ext, $types)) {
            echo "<script>confirm('文件类型必须为图片！');window.location.href='index.php';</script>";
            exit;
        }
        $upload_file = $_FILES['file']['tmp_name'];
        $new_name = date("Y" . "m" . "d" . "H" . "i" . "s") . '.' . $ext;
        $target_dir = '/var/www/html/loveSpace/img/' . $new_name;
        if (move_uploaded_file($upload_file, $target_dir)) {
            $get_time = date("Y-m-d H:i:s");
            $insert = "insert into images(path,date,name) values('$target_dir','$get_time','$new_name')";
            $result = mysqli_query($connect, $insert);
            if ($result) {
                echo "<script>confirm('上传成功！');window.location.href='index.php';</script>";
            } else {
                echo "<script>confirm('上传失败！');window.location.href='index.php';</script>";
            }
        }
    } else {
        echo "<script>confirm('数据库连接失败！');</script>";
    }
}
?>

<body>

    <p>单张图片大小不得超过100MB！</p>

    <div id="vue">
        <div style="margin: 1rem">
            <van-uploader v-model="fileList" multiple accept :max-count="10" />
            <!-- :max-count="10"最大上传10个  -->
            <!-- accept识别所有文件类型 -->
        </div>
        <button @click="getupload">biubiu～</button>
    </div>

</body>
<script>
    new Vue({
        el: '#vue',
        data() {
            return {
                fileList: []
            }
        },
        mounted() {},
        methods: {
            getupload() {
                console.log(this.fileList[0])
                for (let i in this.fileList) {
                    var formData = new FormData();
                    formData.append("file", this.fileList[i].file);
                    formData.append("is_https", 1);
                    axios({
                        method: 'post',
                        url: 'https://yourk.top/loveSpace/upload.php',
                        data: formData
                    }).then(function(res) {
                        if (res) {
                            swal("上传成功！", "爱你么么哒❤️", "success").then(function() {
                                window.location.reload();
                            });
                        } else {
                            swal("上传失败！", "也爱你么么哒❤️", "error").then(function() {
                                window.location.reload();
                            });
                        }
                    });
                }
            }
        }
    });
</script>

</html>