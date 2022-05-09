


<?php
require_once("layout/header.php");
?>

<div class="small-container">
    <section id= "blog-home" class = "small-1-container">
        <h2 class="titel">Shopping Cart</h2>
    </section>

    <section id ="cart-container" >
    <table width = "100%">
     <thead>
        <tr>
            <th> Remove</th>
            <th> Image</th>
            <th> Product</th>
            <th> Size</th>
            <th> Quantity</th>
            <th> Total</th>

        </tr>
    </thead>
        <tbody>
            <tr>
                <td ><a href = "#"> <i class="fas fa-trash-alt" style="font-size:48px;color:red;"></i></a></td>
                <td><img src = "../image/đồng phục vnu.jpeg" alt = ""></td>
                <td><h5> Đồng Phục </h5></td>
                <td>
                <select>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                    <option>XXL</option>
                    <option>XXXL</option>
                </select>
                </td>
                <td><h5><input value ="1" type="number"></h5></td>
                <td><h5> 330k</h5></td>
            </tr>

            <tr>
                <td ><a href = "#"> <i class="fas fa-trash-alt" style="font-size:48px;color:red;"></i></a></td>
                <td><img src = "../image/đồng phục vnu.jpeg" alt = ""></td>
                <td><h5> Đồng Phục </h5></td>
                <td>
                <select>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                    <option>XXL</option>
                    <option>XXXL</option>
                </select>
                </td>
                <td><h5><input value ="1" type="number"></h5></td>
                <td><h5> 330k</h5></td>
            </tr>           
        </tbody>
    </table>
    </section>

    <section class="total-cart">
        <table>
            <tr> 
                <td>Total Quantity </td>
                <td> 3</td>
            </tr>
            <tr>
                <td> Total </td>
                <td> 700k</td>
            </tr>
        </table>
    </section>
    <section class = "button" width="200px" height = "40px" >
        <button width="200px" height = "40px"> Borrow Confirmation </button>
    </section>
</div>
<?php
require_once("layout/footer.php");
?>