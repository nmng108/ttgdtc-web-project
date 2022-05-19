<!-- Specify the correct variables $root_dir and $title base on the calling file before requiring/including this file. -->

<!DOCTYPE html>
<html>
<head>
	<?=include_once("$root_dir/includes/headtag.php");?>
	<style type="text/css">
		.main {
			min-height: 700px;
		}
        body {
            font: 15px Arial, sans-serif;
        }
	</style>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top py-1" style="background-color: #5A332F;">
        <a class="navbar-brand" href="<?=$root_dir?>/">
            <img src="<?=$root_dir?>/assets/images/logovnu.png" width="120px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?="$root_dir/"?>">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Yêu cầu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$root_dir?>/cart">Giỏ hàng</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="<?=$root_dir?>/account/logout.php">Đăng xuất</a>
                </li>    
            </ul>
        </div>  
    </nav>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>Trung tâm giáo dục thể chất, ĐHQGHN</h1>
        <h3>Web site cho thuê mượn dụng cụ thể thao</h3> 
    </div>
	<!-- header END -->