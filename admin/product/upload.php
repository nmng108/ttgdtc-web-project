<?php
$root_dir = "../..";
$title = "Đăng dụng cụ mới";

require_once("$root_dir/database/manager.php");
include_once("$root_dir/includes/utilities.php");

define('ITEM_IMAGE', 'item_image');
define('ITEM_NAME', 'item_name');
define('ITEM_QUANTITY', 'item_quantity');
define('ITEM_CATEGORY', 'item_category');
define('ITEM_DESCRIPTION', 'item_description');

$accepted_file_types = ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.pjpeg', '.tiff', '.bmp'];

if (isset($_POST['submit']) && isset($_FILES[ITEM_IMAGE])) {
    $item_name = isset($_POST[ITEM_NAME]) ? $_POST[ITEM_NAME] : NULL;
    $item_quantity = isset($_POST[ITEM_QUANTITY]) ? $_POST[ITEM_QUANTITY] : NULL;
    $item_category = isset($_POST[ITEM_CATEGORY]) ? $_POST[ITEM_CATEGORY] : NULL; 
    $item_description = isset($_POST[ITEM_DESCRIPTION]) ? $_POST[ITEM_DESCRIPTION] : NULL;

    // may to change ITEM_NAME value
    $file = &$_FILES[ITEM_IMAGE];
    
    $file_location = "$root_dir/uploads/images/";
    $file_type = strtolower(pathinfo($file['name'][0], PATHINFO_EXTENSION));
    $satisfied = true;    

    // Check file type.
    if (!in_array(".$file_type", $accepted_file_types)) { 
        ?>
        <script>console.log('/"<?=$file['name'][0]?>/" is of invalid file type.');</script>
        <?php
        $satisfied = false;
    }

    // Check file size, limit a file size to 20MB.
    if ($file['size'][0] > (20 * pow(1024, 2))) { 
        ?>
        <script>console.log('/"<?=$file['name'][0]?>/" is too large.');</script>
        <?php
        $satisfied = false;
    }

    if (!$satisfied) {
        unset($_FILES);
        exit("The file uploaded did not match the requirements");
    }

    // Make new directory if not already exists.
    if (!file_exists($file_location)) {
        mkdir($file_location);
        echo "<script>console.log(made new directory $file_location);</script>";
    }

    $file_name = user_defined_uniqid() . "." . $file_type;
    $file_uri = $file_location . $file_name;

    // Firstly we upload image
    if (move_uploaded_file($file['tmp_name'][0], $file_uri)) {
        if ($item_name != NULL && $item_quantity != NULL && $item_category != NULL) {
            try{
                // Then insert new item in the table Products if image is uploaded.
                $query = "INSERT INTO `Products` (`itemName`, `availableQuantity`, `category`, `primaryImage`, `description`) 
                        VALUES('$item_name', '$item_quantity', '$item_category', '$file_name', '$item_description');";
                $result = run_mysql_query($query);
                
                if ($result === true) {
                    $query = "SELECT MAX(itemCode) itemCode FROM Products WHERE category = '".SPORT_EQUIPMENT."'";
                    $result = run_mysql_query($query)->fetch_array();
                    
                    if ($result == null) exit();

                    $item_code = $result['itemCode'];
                    // Finally we update new item in the table SportEquipments if 2 steps above is done.
                    $query = "INSERT INTO `SportEquipments` (`itemCode`) 
                            VALUES('$item_code')";
                    $result = run_mysql_query($query);
                    
                    if ($result == true) {
                        // Redirect to index.php if all's done.
                        header("Location: ./");
                    }
                } else {
                    echo "Insertion failed.";
                    unlink($file_uri);
                }
            } catch(Exception $e) {
                exit($e->getMessage());
                echo "<br>Insertion failed.";
                unlink($file_uri);
            }
        }
    } else {
        echo "<script>console.log('" . basename($file_uri) . " cannot be uploaded.');</script>";
    }
    unset($_FILES);
}
?>

<script>
    // Remove data to prevent the form from being resubmitted when refreshing this page.
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<!-- UI -->
<?php
include_once("$root_dir/admin/layouts/header.php");
?>
<h3>Đăng Dụng Cụ Thể Thao Mới</h3>

<form action="" method="post" enctype='multipart/form-data'>
    <label for="<?=ITEM_NAME?>">Tên dụng cụ </label>
    <input type="text" name="<?=ITEM_NAME?>" id="" required>
    <br>
    <br>
    <label for="<?=ITEM_QUANTITY?>">Số lượng </label>
    <input type="number" name="<?=ITEM_QUANTITY?>" id="" required>
    <br>
    <br>
    <label for="<?=ITEM_CATEGORY?>">Danh mục </label>
    <select name="<?=ITEM_CATEGORY?>" value="" required>
        <option value="SPORT_EQUIPMENT">Dụng cụ thể thao</option>
        <option value="UNIFORM" disabled>Đồng phục</option>
    </select>
    <br>
    <br>
    <label for="<?=ITEM_IMAGE?>[]">Ảnh </label>
    <input type="file" name="<?=ITEM_IMAGE?>[]" id="<?=ITEM_IMAGE?>" required accept="<?=join(', ', $accepted_file_types)?>" >
    <br>
    Xem trước
    <div class="image-preview">

    </div>
    <br>
    <br>
    <label>Mô tả</label>
    <input type="textarea" name=<?=ITEM_DESCRIPTION?> id="">
    <br>
    <br>
    <input type="submit" name="submit" value="Lưu">
</form>

<script type="text/javascript">
const IMAGE_INPUT = document.getElementById('<?=ITEM_IMAGE?>');
const IMAGE_PREVIEW = document.querySelector('.image-preview');
const SUBMIT_BUTTON = document.querySelector('[name="submit"]');
const FILE_TYPES = [
    "image/bmp",
    "image/gif",
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/tiff",
    "image/webp",
];

IMAGE_INPUT.addEventListener("change", updateImageDisplay);

function updateImageDisplay() {
    while(IMAGE_PREVIEW.firstChild) {
        IMAGE_PREVIEW.removeChild(IMAGE_PREVIEW.firstChild);
    }

    let curFiles = IMAGE_INPUT.files;

    if (IMAGE_INPUT.files === 0) {
        const para = document.createElement('p');
        para.textContent = 'No files currently selected for upload';
        IMAGE_PREVIEW.appendChild(para);
    } else {
        const file = curFiles[0];
        const para = document.createElement('p');
        
        if(validFileType(file)) {
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.style.width = "25%";

            para.textContent = `File size: ${returnFileSize(file.size)}.`;

            IMAGE_PREVIEW.appendChild(image);
            IMAGE_PREVIEW.appendChild(para);

            SUBMIT_BUTTON.disabled = false;

        } else {
            para.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
            IMAGE_PREVIEW.appendChild(para);

            SUBMIT_BUTTON.disabled = true;
        }
        
    }
}

function validFileType(file) {
    return FILE_TYPES.includes(file.type);
}

function returnFileSize(number) {
    if (number < 1024) {
        return number + 'bytes';
    } else if(number >= 1024 && number < 1048576) {
        return (number/1024).toFixed(1) + 'KB';
    } else if(number >= 1048576) {
        return (number/1048576).toFixed(1) + 'MB';
    }
}
</script>
