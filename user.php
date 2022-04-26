<!-- // hiển thị danh sách người dùng đã đk trong hệ thống
// nếu người dùng chưa đăng nhập thì tự động chuyển sang trang login
1. tìm hiểu về cookie:
so sánh cookie và localstorage
- giống nhau: cùng được lưu trữ và quản lí bởi trình duyệt web
-khác biệt:
+cookie: 
        có thể thiết lập một thời gian sống->tới giới hạn->tự động xoá đi
        thêm sửa xoá bằng php hoặc js
        khi gửi yêu cầu lên server(request URL) thì nó sẽ gửi toàn bộ các cookie tương ứng gửi kèm lên server

DU AN
DATABASE:
- email
- name
- student ID
- password
- dia chi
- so dien thoai
 -->

<?php
//  setcookie('hello', 'test', time() + 5,'/');
