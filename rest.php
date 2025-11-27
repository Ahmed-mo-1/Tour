



















<style>

.open-now-btn {
margin: 0 auto;
padding: 1px;
background: #000;
text-align: center;
border-radius: 20px;
position: relative;
z-index: 10;
}

.open-now-btn button {
background: #000;
color:white;
}

.open-now-btn button:hover {
background: #000;
color:white;
letter-spacing : 1px;
}

@property --angle{
  syntax: "<angle>";
  initial-value: 0deg;
  inherits: false;
}

.open-now-btn::after, .open-now-btn::before{
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  background-image: conic-gradient(from var(--angle), #0000, #00ff00, #0000, #00ff00, #0000) !important;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  z-index: -1;
  padding: 1px;
  border-radius: 20px;
  animation: 3s spin linear infinite;
}
.open-now-btn::before{
  filter: blur(1.5rem);
  opacity: 0.5;
}

.open-now-btn:hover::before{
  filter: blur(2rem);
  opacity: 0.7;
}

@keyframes spin{
  from{
    --angle: 0deg;
  }
  to{
    --angle: 360deg;
  }
}














.close-now-btn {
margin: 0 auto;
padding: 1px;
background: #000;
text-align: center;
border-radius: 20px;
position: relative;
z-index: 10;
}

.close-now-btn button {
background: #000;
color:white;
}

.close-now-btn button:hover {
background: #000;
color:white;
letter-spacing : 1px;
}

@property --angle{
  syntax: "<angle>";
  initial-value: 0deg;
  inherits: false;
}

.close-now-btn::after, .close-now-btn::before{
  content: '';
  position: absolute;
  height: 100%;
  width: 100%;
  background-image: conic-gradient(from var(--angle), #0000, #ff0000, #0000, #ff0000, #0000) !important;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  z-index: -1;
  padding: 1px;
  border-radius: 20px;
  animation: 3s spin linear infinite;
}
.close-now-btn::before{
  filter: blur(1.5rem);
  opacity: 0.5;
}

.close-now-btn:hover::before{
  filter: blur(2rem);
  opacity: 0.7;
}

@keyframes spin{
  from{
    --angle: 0deg;
  }
  to{
    --angle: 360deg;
  }
}

</style>


<div style="position: absolute ; bottom : 30px ; left : 20px ; border-radius: 50px; background: #0000;  height: 50px; display: flex ; align-items: center; justify-content: center; gap: 10px" id="info-reservation">


<div style="background-image: url(<?php echo $restaurant->thumbnail; ?>);
    background-size: cover;
    width: 30px;
    height: 30px;
    border-radius: 50px;"></div>
<div style="font-size: 12px"><?php echo $restaurant->name;?> • </div>



<?php if($restaurant->reservation == 1){?>
<div class="reservation-btn"><button class="popup-trigger" id="reservation-btn" data-translate="reservation-trigger-btn">
<div class="english">Reserve Now</div>
<div class="arabic">احجز الان</div>
</button></div>
<?php } 
elseif ($restaurant->reservation == 2){
?>

<div class="reservation-btn"><a href="https://wa.me/<?php echo $restaurant->whatsapp_number; ?>?text=مرحبا، أريد حجز الشاليه!
%0A
متى متوفر؟"><button>
<div class="english">Contact Us</div>
<div class="arabic">تواصل معنا</div>
</button>
</a>
</div>

<?php
}
elseif($restaurant->reservation == 0 && date('H:i:s') >= $restaurant->workingfrom && date('H:i:s') <= $restaurant->workingto ) {
?>
<div class="open-now-btn"><button class="" id="open-now-btn">Open Now <?php //echo $restaurant['workingfrom']; //echo date_default_timezone_get(); ?></button></div>
<?php }

else {?>
<div class="close-now-btn"><button class="" id="close-now-btn">Close Now</button></div>
<?php
}



//date('Y-m-d H:i:s');
?>

</div>

























<div class="tour-btns">

<?php if($restaurant->have_food_menu == 1){?>
<div class="popup-trigger" id="food-menu-btn">
<img src="<?php //echo $ROOT ;?>/assets/icons/foodmenu.svg">
</div>
<?php } ?>

<?php if($restaurant->have_floors == 1){?>
<div id="toggleFloorButton" onclick="toggleButtons()">
<img src="<?php //echo $ROOT ;?>/assets/icons/stairs.svg">
</div>

<div id="buttonContainer" class="hidden">
<div id="toggleFloorButton1" onclick="toggleButtons()" class="extraButton">
<?php echo $restaurant->first_floor_name ; ?>
</div>
<div id="toggleFloorButton2" onclick="toggleButtons()" class="extraButton vip">
<?php echo $restaurant->second_floor_name ; ?>
</div>


<?php if (isset($restaurant->third_floor_name) && is_string($restaurant->third_floor_name) && strlen($restaurant->third_floor_name) > 3) { ?>
<div id="toggleFloorButton3" onclick="toggleButtons()" class="extraButton vip">
<?php echo $restaurant->third_floor_name ; ?>
</div>
<?php } ?>



</div>
<?php } ?>


<style>
.floor-btns-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}


#buttonContainer {
    width: 115px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin: 10px;
    position: absolute;
    top: -34px;
    right: 40px;
}

/* Hide buttons initially */
.hidden {
    display: none !important;
}

.extraButton {
    animation: fadeIn 0.5s ease-in-out;
    background: #000a;
    padding: 10px;
    border-radius: 10px;
    text-align: center;
}

/* Animation for fade-in effect */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function toggleButtons() {
    const buttonContainer = document.getElementById("buttonContainer");
    buttonContainer.classList.toggle("hidden");
}
</script>









<?php if($restaurant->have_highlight == 1){?>
<div id="startTourButton">
<img src="<?php //echo $ROOT ;?>/assets/icons/eye.svg">
</div>
<?php } ?>


<div id="share-menu-btn" onclick="shareContent()">
<img src="<?php //echo $ROOT ;?>/assets/icons/share.svg">
</div>



<script>

function shareContent() {
const shareData = {
  title: document.title,
  text: 'Check out this page!',
  url: window.location.href
};

if (navigator.share) {
  navigator.share(shareData)
	.then(() => console.log('Content shared successfully!'))
	.catch((error) => console.error('Error sharing:', error));
} else {
  alert('Share not supported on this browser.');
}
}

</script>




<?php if ($restaurant->reservation != 2){ ?>
<div class="popup-trigger" id="login_menu_btn">
<img src="<?php //echo $ROOT ;?>/assets/icons/user.svg">
</div>
<?php } ?>


<?php if ($isLoggedIn === 'test'): ?>
<a href="https://tourapp.tech/upcoming/admin/client/reservations.php" class="popup-trigger" >
<img src="<?php //echo $ROOT ;?>/assets/icons/user.svg">
</a>
<?php endif; ?>


<?php if ($restaurant->reservation != 2){ ?>
<div class="popup-trigger" id="more-btn">
<img src="<?php //echo $ROOT ;?>/assets/icons/more.svg">
</div>
<?php } ?>

<div id="fullscreenBtn">
<img src="<?php //echo $ROOT ;?>/assets/icons/fullscreen.svg">
</div>

</div>




















<div class="showcase-logo" id="showcase-logo"
style="position : absolute ;
z-index: 999 ;
width : 90px;
height : 24px; 
right: 0 ;
bottom : 0 ;
display: flex;
align-items: center;
justify-content: center ;
background-color: #33000020;
backdrop-filter: blur(10px);
-webkit-backdrop-filter: blur(10px); 
border-radius: 14px 0 0 0;" 
>

<img src="<?php //echo $ROOT ;?>/assets/imgs/logo.webp" style="width: auto ; height: 50%; filter: brightness(0) invert(1)">




</div>

















<div id="overlay" style="overscroll-behavior: none; touch-action: none"></div>

<div class="slide-up-container" style="overscroll-behavior: none; touch-action: none">
<div class="drag-handle"></div>


<style>
.slideup-container {
width: 100%;display: flex ; flex-direction: column ; gap : 4px;  padding: 40px
}

.slideup-container p {width: clamp(200px, 100%, 450px); font-size: 14px }
.slideup-container iframe{border:0;width: 500px; height: 500px}

@media(max-width: 700px){
.slideup-container {
width: 100%;display: flex ; flex-direction: column ; gap : 4px;  padding: 20px 0
}
.slideup-container iframe{border:0;width: 100%; aspect-ratio: 1}
}

</style>



<div id="info-menu" class="slideup-container">
<?php
/*
echo $restaurant['restaurant_id'];
echo $restaurant->name;
echo $restaurant->category;
echo $restaurant['description'];
echo $restaurant['location'];
echo $restaurant['email'];
echo $restaurant['phone'];
echo $restaurant['password'];
echo $restaurant['workingfrom'];
echo $restaurant['workingto'];
echo $restaurant['slug'];
echo $restaurant['tour_id'];
*/
?>
<h2><?php $restaurant->name; ?></h2>
<h4><?php $restaurant->category; ?></h4>
<br>
<p><?php $restaurant->description; ?></p>
<br>
<?php $restaurant->location; ?>
<br>
Working hours: <?php $restaurant->workingfrom; ?> - <?= $restaurant->workingto; ?>
<br>
 Contact: <?php $restaurant->phone; ?><br><?php $restaurant->email; ?>






</div>



































<?php if ($restaurant->have_food_menu == 1) { ?>
<div id="food-menu" style="margin: auto">
<div>

<style>
.food-slideup-container {
    gap: 1rem;
    grid-template-columns: repeat(2, 1fr);
    width: 100%;
    margin: auto;
}

@media (min-width: 768px) {
.food-slideup-container {
        grid-template-columns: repeat(4, 1fr);
    }
}

/* Card styling */
.card {
    background-color: #fff2;
    backdrop-filter: blur(6px);
    border-radius: 8px;
    padding: 4px;
    text-align: center;
}

.card img {
    max-width: 100%;
    border-radius: 8px;
    height: 150px;
    object-fit: cover;
}

.card-title {
    font-size: 1.2rem;
    margin: 0.5rem 0;
}

.card-price {
    width: 100% !important;
    font-size: 1rem;
    color: #fff;
}

.subcategory-container {
    display: grid;
    justify-content: space-between;
    gap: 20px;
    grid-template-columns: repeat(4, 1fr);
}

@media (max-width: 700px) {
.subcategory-container {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php
$profile_sql = "SELECT * FROM foods WHERE restaurant_id = '$restaurant_id' ORDER BY category, subcategory";
$profile_result = $conn->query($profile_sql);

$current_category = "";
$current_subcategory = "";

if ($profile_result->num_rows > 0) {

    echo "<div class='slideup-container food-slideup-container'>";

    while ($row = $profile_result->fetch_assoc()) {

        // New Category
        if ($current_category !== $row['category']) {

            // Close previous category block
            if ($current_category !== "") {
                echo "</div></div>";
            }

            $current_category = $row['category'];
            $current_subcategory = "";

            echo "<div class='category-container'>";
            echo "<h2 class='category-title'>{$current_category}</h2>";
        }

        // New Subcategory
        if ($current_subcategory !== $row['subcategory']) {

            if ($current_subcategory !== "") {
                echo "</div>";
            }

            $current_subcategory = $row['subcategory'];

            echo "<h3 class='subcategory-title'>{$current_subcategory}</h3>";
            echo "<div class='subcategory-container'>";
        }

        // Food Card
        echo "
        <div class='card'>
            <div style='width: 100%; aspect-ratio: 1; background: black;'>
                <img style='width: 100%; aspect-ratio: 1; object-fit: cover'
                     src='{$row['image']}' alt='{$row['name']}'>
            </div>
            <h3 class='card-title'>{$row['name']}</h3>
            <p class='card-price'>{$row['price']}</p>
        </div>";
    }

    // Close last opened sections
    echo "</div></div>";
    echo "</div>"; // main grid

} else {
    echo "<p>No food items found</p>";
}
?>

</div>
</div>

<?php } ?>














    <div id="reservation-menu" style="display: flex; align-items: center;">
    <div id="reservation_data" style="width: clamp(200px, 100%, 500px);">



    <?php 
    
    if ($restaurant->reservation != 2){?>













<style>
#passwordRequirements p {
font-size: 9px;
}

#passwordRequirements {
display: grid;
grid-template-columns: 1fr 1fr 1fr;
width: clamp(200px,100%, 400px);
grid-template-rows: 20px;
padding-block: 10px;
}
.is-valid {
border-color: #00ff00 !important;
}

.is-invalid {
border-color: #999 !important;
}

.strength {
font-size: 9px;
}

.weak {
color: red !important;
}

.medium {
color: orange !important;
}

.strong {
color: #00ff00 !important;
}

.requirement {
font-size: 0.9em;
color: #999 !important;
}

.requirement.valid {
color: #00ff00 !important;
}
.valid {
color: #00ff00 !important;
}
/*




#myForm {padding : 15px 0; display: flex; flex-direction: column; gap: 10px; width: clamp(200px, 100%, 500px)}




</style>















<style>
/*
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
  display: none;
  -webkit-appearance: none;
}
*/

/*
input[type="date"],
input[type="time"] {
  padding: 10px;
}
*/

.select {
position: relative;
}


.select::after {
  content: '+';
  font-size: 17px ;
  font-weight: bold;
  color: #fff;
  transform: rotate(90deg);
  right: 15px;
  top: 15px;
  padding: 0 0 2px;
  position: absolute;
  pointer-events: none;
}

.select select {
  appearance: none;
  -moz-appearance: none;
  -webkit-appearance: none;
}


select {
    width: 100% !important;
    background: #fff2 !important;
    border: none !important;
    border-radius: 4px !important;
    color: white !important;
    margin-top: 4px !important;
}




</style>







<style>
/* Hide all steps initially */
.form-step {
display: none;
}

/* Show only the active step */
.form-step.active {
display: block;
}

/* Style the navigation buttons */
.form-navigation {
display: flex;
justify-content: space-between;
margin-top: 10px;
}



#nextBtn {
width: 100%;
background : #fff2;
color: #fff5;
transition: 1s;
border-radius: 4px;
padding : 14px; 
}

#prevBtn {
width: 100%;
background : #fff;
color: #000;
transition: 1s;
border-radius: 4px;
padding : 14px; 
}

#nextBtn.active:hover {
width: 100%;
background : #fffa;
color: #000;
}


#nextBtn.active {
width: 100%;
background : #fff;
color: #000;
}


#confirm {
display: none;
background : #fff2;
color: #fff5;
}

#confirm.active {
display: flex !important;
background : #f00;
color: #fff;
}









</style>












<h2 id="makereservationtitle">
<div class="english">Make a Reservation</div>
<div class="arabic">بيانات الحجز</div>
</h2>

<form id="myForm" method="POST" action="admin/client/make_reservation.php">






















    <style>
        .time-buttons {
            display: grid;
            grid-template-columns : repeat(5,1fr);
            flex-wrap: wrap;
            gap: 4px;
        }
        .time-button {
            padding: 8px 12px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .time-button:hover {
            background-color: #e0e0e0;
        }
        .time-button.selected {
            background-color: #007bff;
            color: white;
        }
    </style>





<div id="form_first_step" class="form-step active">

<br>
<input style="display: none" type="text" id="lang-input" name="lang-input" value="en" required>
<input style="display: none" type="text" name="restaurant_name" value="<?php echo $restaurant->name; ?>" required>
<input style="display: none" type="text" name="restaurant_id" value="<?php echo $restaurant->restaurant_id; ?>" required>


<div style="display: flex ; gap: 10px ; justify-content: space-between; flex-direction: column">

<div style="width: 100%">
<p class="english">Date</p>
<p class="arabic">التاريخ</p>
<input class="step-one-input" type="date" id="date" name="reservation_date" placeholder="reservation_date" required>
</div>

<div style="width: 100%">
        <p class="english">Time</p>
        <p class="arabic">الوقت</p>
        <input type="hidden" id="selected_time" name="reservation_time" required>
        <div id="time-buttons-container" class="time-buttons"></div>
</div>

</div>

<br>
<p class="english">Member Count</p>
<p class="arabic">الافراد</p>
<div class="select step-one-input">
<label>
<select type="number" id="member_count" name="member_count" required>
<option selected="selected" value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
</label>
</div>


<p id="dateError">

<!--
<div class="english">Please Select A Date</div>
<div class="arabic">
من فضلك اختار التاريخ
</div>
-->

</p>
<p id="timeError">

<!--
<div class="english">Please Select A Time</div>
<div class="arabic">
من فضلك اختار الوفت
</div>
-->

</p>

</div>




















<div class="form-navigation">
<button type="button" id="prevBtn" onclick="nextStep(-1)">
<div class="english">Previous</div>
<div class="arabic">السابق</div>
</button>
<button type="button" id="nextBtn" onclick="nextStep(1)">
<div class="english">Next</div>
<div class="arabic">التالي</div>
</button>
</div>

























<?php //if (!$_SESSION['user_id']): ?>
<div id="form_second_step" class="form-step">

<style>
    .field {
    margin-top: 32px;
}
</style>


<div class="field">
<div class="english">Name</div>
<div class="arabic">الاسم</div>
<input class="step-two-input" type="text" id="name" name="name" placeholder="" required>
</div>

<div class="field">
<div class="english">Email</div>
<div class="arabic">الايميل</div>
<input class="step-two-input" type="email" id="email" name="email" placeholder="" required>
<p id="emailError"></p>
</div>

<div class="field">
<div class="english">Phone Number</div>
<div class="arabic">رقم الهاتف</div>
<input class="step-two-input" type="text" name="phone_number" id="phone_number" placeholder="" required>
<p id="phoneError"></p>
</div>

<div class="field">
<div class="english">Password</div>
<div class="arabic">كلمة المرور</div>
<input class="step-two-input" type="password" id="password" name="password" placeholder="" autocomplete="off" required>
        <div id="passwordRequirements">
            <p class="requirement" id="lengthReq"><span class="english">At least 8 characters</span><dispanv class="arabic">8 احرف علي الاقل</span></p>
            <!--<p class="requirement" id="uppercaseReq">Uppercase letter</p>-->
            <p class="requirement" id="lowercaseReq"><span class="english  ">Lowercase letter</span><span class="arabic">احرف صغيرة</span></p>
            <p class="requirement" id="numberReq"><span class="english  ">Numbers</span><span class="arabic  ">ارقام</span></p>
            <!--<p class="requirement" id="specialReq">@$!%*?&</p>-->
			<!--<p class="strength" id="passwordStrength"></p>-->
        </div>
        <span class="error" id="passwordError">
<div class="english">Weak Password</div>
<div class="arabic">كلمة مرور ضعيفة</div>
        </span>
</div>



</div>
<?php //endif; ?>























<label id="custom-checkbox">
<input type="checkbox" id="termsagreement1" name="termsagreement" required>
<!--<span class="customtermsagreement"></span>-->
<div style="width: 100%; font-size: 12px">

<div class="english">
I agree to the terms and conditions <a href="https://tourapp.tech/upcoming/about/terms-privacy-policy" target="_blank" style="color: white">More</a>
</div>
<div class="arabic">
اوافق علي الشروط والاحكام  <a href="https://tourapp.tech/upcoming/about/terms-privacy-policy" target="_blank" style="color: white"> المزيد </a>
</div>


</div>
</label>

<button type="submit" id="confirm" name="reserve">
<div class="english">Reserve</div>
<div class="arabic">احجز</div>
</button>

<style>

/* Base styles */
#custom-checkbox {
display: none;
align-items: center;
cursor: pointer;
font-size: 16px;
margin : 10px 0;
gap : 10px
}
#custom-checkbox.active {
display: inline-flex !important;
}

#custom-checkbox input {
 /* Hide the default checkbox */
width: 20px;
aspect-ratio: 1;
margin : 0 !important;

}

/* Custom checkbox design */
#custom-checkbox span {
width: 30px;
height: 30px;
display: flex;
align-items: center;
justify-content: center;
border: 2px solid #007bff; /* Border color */
border-radius: 10px; /* Rounded corners */
margin-right: 8px;
transition: background-color 0.3s, border-color 0.3s;
}

/* Checkmark styles when checked */
#custom-checkbox input:checked + span {
background-color: #007bff;
border-color: #007bff;
position: relative;
}

#custom-checkbox input:checked + span::after {
content: "";
width: 6px;
height: 10px;
border: solid white;
border-width: 0 2px 2px 0;
transform: rotate(45deg);
}


#custom-checkbox.error {
color: red;
}

</style>














</form>




























<?php 

global $wpdb;

// Sanitize restaurant_id
$restaurant_id = intval( $restaurant->restaurant_id );

// Prepare and run the query
$datetimequery = $wpdb->prepare("
    SELECT 
        DATE_FORMAT(workingfrom, '%%H:%%i') AS formatted_workingfrom_time,
        DATE_FORMAT(workingto, '%%H:%%i') AS formatted_workingto_time
    FROM {$wpdb->prefix}rs_restaurants
    WHERE restaurant_id = %d
", $restaurant_id);

$datetimevalues = $wpdb->get_row( $datetimequery, ARRAY_A );

// Fetch the restaurant data
if ( $datetimevalues ) {
    $workingfromvalue = $datetimevalues['formatted_workingfrom_time'];
    $workingtovalue   = $datetimevalues['formatted_workingto_time'];
}



?>


    <script>
        // Safer DOM ready function
        function domReady(fn) {
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                setTimeout(fn, 1);
            } else {
                document.addEventListener('DOMContentLoaded', fn);
            }
        }

        // Function to generate time buttons
function generateTimeButtons() {
    const container = document.getElementById('time-buttons-container');
    if (!container) return;

    const startTime = "<?php echo $workingfromvalue; ?>";
    const endTime = "<?php echo $workingtovalue; ?>";

    // Convert times to Date objects for easier manipulation
    const start = new Date(`1970-01-01T${startTime}`);
    let end = new Date(`1970-01-01T${endTime}`);

    // Handle the case where end time is earlier than start time (crossing midnight)
    if (end <= start) {
        end = new Date(`1970-01-02T${endTime}`); // Move end time to the next day
    }

    container.innerHTML = ''; // Clear existing buttons

    // Generate buttons with 15-minute intervals
    let currentTime = new Date(start);
    while (currentTime < end) {
        const button = document.createElement('button');
        button.type = 'button';
        button.classList.add('time-button');
        
        // Format time to HH:MM
        const hours = currentTime.getHours().toString().padStart(2, '0');
        const minutes = currentTime.getMinutes().toString().padStart(2, '0');
        button.textContent = `${hours}:${minutes}`;
        
        button.addEventListener('click', function() {
            // Remove selected class from all buttons
            container.querySelectorAll('.time-button').forEach(btn => 
                btn.classList.remove('selected')
            );
            
            // Add selected class to clicked button
            this.classList.add('selected');
            
            // Set hidden input value
            const selectedTimeInput = document.getElementById('selected_time');
            if (selectedTimeInput) {
                selectedTimeInput.value = this.textContent;
                
                // Trigger input event for validation
                const dateInput = document.getElementById('date');
                if (dateInput) {
                    const event = new Event('input');
                    dateInput.dispatchEvent(event);
                }
            }
        });

        container.appendChild(button);

        // Increment time by 15 minutes
        currentTime.setMinutes(currentTime.getMinutes() + 15);
    }
}


        // Validation function
        function validateInputs() {
            let isValid = true;
            
// Time validation
const selectedTimeInput = document.getElementById('selected_time');
const timeErrorElement = document.getElementById('timeError');
const time = selectedTimeInput ? selectedTimeInput.value : '';

const startTime = "<?php echo $workingfromvalue; ?>";
const endTime = "<?php echo $workingtovalue; ?>";

let inputTime = new Date(`1970-01-01T${time}`);
let start = new Date(`1970-01-01T${startTime}`);
let end = new Date(`1970-01-01T${endTime}`);

// Handle case where end time is less than start time (end is the next day)
if (end <= start) {
    end.setDate(end.getDate() + 1); // Adjust end to the next day
    if (inputTime < start) {
        inputTime.setDate(inputTime.getDate() + 1); // Adjust inputTime to the next day if before start
    }
}

if (timeErrorElement) {
    // Validate input time
    if (!time || inputTime < start || inputTime >= end) {
        timeErrorElement.innerHTML = `
        <div class="english">Please select a time between ${startTime} and ${endTime}.</div>
        <div class="arabic">اختر وقت بين ${startTime} و ${endTime}.</div>
        `;
        timeErrorElement.style.display = "block";
        isValid = false;
    } else {
        // Clear error if valid
        timeErrorElement.textContent = "";
        timeErrorElement.style.display = "none";
    }
}



            
            // Date validation
            const dateInput = document.getElementById('date');
            const dateErrorElement = document.getElementById('dateError');
            const date = dateInput ? dateInput.value : '';
            
            if (dateErrorElement) {
                if (!date) {
                    dateErrorElement.innerHTML = `
                    <div class="english">Please select a date.</div>
                    <div class="arabic">من فضلك اختر تاريخ</div>
                    `;
					dateErrorElement.style.display= "block";
                    isValid = false;
                } else {
                    dateErrorElement.textContent = "";
					dateErrorElement.style.display= "none";
                }
            }
            
            // Button activation logic
            const nextBtn = document.getElementById("nextBtn");
            const confirmBtn = document.getElementById('confirm');
            
            if (nextBtn) {
                isValid ? nextBtn.classList.add('active') : nextBtn.classList.remove('active');
            }
            /*
            if (confirmBtn && <?php //echo $isLoggedIn ? '0' : '1'; ?> == '0') {
                //isValid ? confirmBtn.classList.add('active') : confirmBtn.classList.remove('active');
            }
            */
            return isValid;
        }

        // Call functions when DOM is ready
        domReady(function() {
            // Generate time buttons
            generateTimeButtons();

            // Add event listeners
            const inputs = document.querySelectorAll('.step-one-input');
            inputs.forEach((input) => {
                input.addEventListener('input', validateInputs);
            });

            // Add date input listener
            const dateInput = document.getElementById('date');
            if (dateInput) {
                dateInput.addEventListener('change', validateInputs);
            }
        });
    </script>















<script>

let currentStep = 0;

function showStep(step) {
const steps = document.querySelectorAll(".form-step");

steps.forEach((el, index) => {
el.classList.toggle("active", index === step);
});

document.getElementById("prevBtn").style.display = step === 0 ? "none" : "inline";
//document.getElementById("nextBtn").textContent = step === steps.length - 1 ? "Submit" : "Next";
document.getElementById("nextBtn").style.display = step === steps.length - 1 ? "none" : "inline";

if(step === steps.length - 1){
document.getElementById('confirm').classList.add('active');
document.getElementById('custom-checkbox').classList.add('active');
}else{
document.getElementById('confirm').classList.remove('active');
document.getElementById('custom-checkbox').classList.remove('active');

}


}




function nextStep(direction) {
const steps = document.querySelectorAll(".form-step");

let isValid = true;



// Time validation
let time = document.getElementById('selected_time').value; 
let startTime = "<?php echo $workingfromvalue; ?>";
let endTime = "<?php echo $workingtovalue; ?>";

let inputTime = new Date(`1970-01-01T${time}`);
let start = new Date(`1970-01-01T${startTime}`);
let end = new Date(`1970-01-01T${endTime}`);

// Handle case where end time is less than start time (end is the next day)
if (end <= start) {
    end.setDate(end.getDate() + 1);
}

// Validation logic
if (
    !time || // No time selected
    inputTime < start || // Time is before the start time
    (inputTime >= end && inputTime < new Date(end - 86400000)) // Invalid time when end is the next day
) {
    document.getElementById("timeError").innerHTML = `
        <div class="english">Please select a time between ${startTime} and ${endTime}.</div>
        <div class="arabic">اختر وقت بين ${startTime} و ${endTime}.</div>
    `;
    document.getElementById("timeError").style.display = "block";
    isValid = true;
} else {
    document.getElementById("timeError").textContent = "";
    document.getElementById("timeError").style.display = "none";
}





//date start
let date = document.getElementById('date').value;
if (!date) {
document.getElementById("dateError").innerHTML = `
                    <div class="english">Please select a date.</div>
                    <div class="arabic">من فضلك اختر تاريخ</div>
`;
document.getElementById("dateError").style.display= "block";
isValid = false;
}
else {
document.getElementById("dateError").textContent = "";
document.getElementById("dateError").style.display= "none";
}
//date start






if (isValid){
currentStep += direction;
}
  // Prevent going out of bounds
  if (currentStep < 0) currentStep = 0;
  if (currentStep >= steps.length) {
    return;
  }

  showStep(currentStep); // Show the current step
}

// Initial display setup
showStep(currentStep);


</script>















<script>


function checkPasswordStrength(password) {
let strength = "Weak";
let strengthClass = "weak";
const lengthReq = document.querySelector("#lengthReq");
//const uppercaseReq = document.getElementById("uppercaseReq");
const lowercaseReq = document.querySelector("#lowercaseReq");
const numberReq = document.querySelector("#numberReq");
//const specialReq = document.getElementById("specialReq");

// Check each requirement
const lengthValid = password.length >= 8;
//const hasUppercase = /[A-Z]/.test(password);
const hasLowercase = /[a-z]/.test(password);
const hasNumber = /\d/.test(password);
//const hasSpecial = /[@$!%*?&]/.test(password);

// Update requirement elements' styles
lengthReq.classList.toggle("valid", lengthValid);
//uppercaseReq.classList.toggle("valid", hasUppercase);
lowercaseReq.classList.toggle("valid", hasLowercase);
numberReq.classList.toggle("valid", hasNumber);
//specialReq.classList.toggle("valid", hasSpecial);

// Determine strength based on requirements met
const passedChecks = [lengthValid, hasLowercase, hasNumber].filter(Boolean).length;


if (passedChecks < 3) {
strength = "weak";
strengthClass = "weak";
document.getElementById('passwordError').innerHTML = `
<div class="english">Weak</div>
<div class="arabic">ضعيف</div>
`;
}


if (passedChecks >= 3) {
strength = "Strong";
strengthClass = "Strong";
document.getElementById('passwordError').innerHTML = `
<div class="english">Strong</div>
<div class="arabic">قوي</div>
`;
}
if (passedChecks === 5) {
strength = "Strong";
strengthClass = "strong";
}

return { strength, strengthClass };
}

const passwordInput = document.getElementById("password");
const passwordStrength = document.getElementById("passwordStrength");
if(<?php if(!$isLoggedIn){echo 1 ;}else{echo 0; } ?> === 1 ){
passwordInput.addEventListener("keyup", function() {
const { strength, strengthClass } = checkPasswordStrength(passwordInput.value);
passwordStrength.textContent = strength;
passwordStrength.className = `strength ${strengthClass}`;
});
}



</script>


















<script>

const twoinputs = document.querySelectorAll('.step-two-input');

twoinputs.forEach((input) => {
input.addEventListener('input', () => {


});
});



</script>














<script>

document.getElementById("myForm").addEventListener("submit", async function(event) {
    
    
    
/*
if (!document.getElementById('termsagreement').checked) {
document.querySelector('#custom-checkbox').classList.add('error');
} else {
document.querySelector('.customtermsagreement').classList.remove('error');
}
*/
    
    
    
event.preventDefault();
let isValid = true;



// Time validation
let time = document.getElementById('selected_time').value; 
let startTime = "<?php echo $workingfromvalue; ?>";
let endTime = "<?php echo $workingtovalue; ?>";

let inputTime = new Date(`1970-01-01T${time}`);
let start = new Date(`1970-01-01T${startTime}`);
let end = new Date(`1970-01-01T${endTime}`);

// Handle case where end time is less than start time (end is the next day)
if (end <= start) {
    end.setDate(end.getDate() + 1); // Adjust end to the next day
    if (inputTime < start) {
        inputTime.setDate(inputTime.getDate() + 1); // Adjust inputTime to the next day if before start
    }
}

// Validation logic
if (!time || inputTime < start || inputTime >= end) {
    document.getElementById("timeError").innerHTML = `
        <div class="english">Please select a time between ${startTime} and ${endTime}.</div>
        <div class="arabic">اختر وقت بين ${startTime} و ${endTime}.</div>
    `;
    document.getElementById("timeError").style.display = "block";
    isValid = false;
} else {
    document.getElementById("timeError").textContent = "";
    document.getElementById("timeError").style.display = "none";
}





// Phone validation (requires intlTelInput initialization)
// Ensure to initialize the phone validation logic as required


// Email validation
const email = document.getElementById("email").value;
if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
document.getElementById("emailError").innerHTML = `<div class="english" style="color: red">Invalid email format.</div><div class="arabic" style="color: red">ايميل غير صالح</div>`;
isValid = false;
} else {
document.getElementById("emailError").textContent = "";
}


//phone
const phoneInput = document.getElementById("phone_number").value;
const phonePattern = /^\+?\d{8,12}$/; // Supports international format

if (!phonePattern.test(phoneInput)) {
document.getElementById("phoneError").innerHTML = `<div class="english" style="color: red">Phone Number Is Not Correct</div><div class="arabic" style="color: red">رقم هاتف غير صحيح </div>`;
isValid = false;
} else {
document.getElementById("phoneError").textContent = "";
}
//phone

// Password validation
const passwordInput = document.getElementById("password");
const passwordStrength = document.getElementById("passwordStrength");
const password = passwordInput.value;


const lengthValid = password.length >= 8;
//const hasUppercase = /[A-Z]/.test(password);
const hasLowercase = /[a-z]/.test(password);
const hasNumber = /\d/.test(password);
//const hasSpecial = /[@$!%*?&]/.test(password);

const passedChecks = [lengthValid, hasLowercase, hasNumber].filter(Boolean).length;

if (passedChecks < 3 ) {
isValid = false;
document.getElementById("passwordError").innerHTML = `
<div class="english" style="color: red">Password is Weak</div>
<div class="arabic" style="color: red">كلمة المرور ضعيفة</div>
`;
}
else {
document.getElementById("passwordError").innerHTML = `
<div class="english" style="color: green">Strong</div>
<div class="arabic" style="color: green">قوي</div>
`;
}

// Password validation




//end if



let form = document.getElementById('myForm');
if (!isValid) {
event.preventDefault();
}
else {
    
/**/
<?php //if(!$_SESSION['user_id']){ ?>
const email = document.getElementById("email").value;

                try {
                    // Send the email to the server via fetch
                    const response = await fetch('<?php echo $clientdirectory; ?>/check-email.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `email=${encodeURIComponent(email)}` // URL-encoded email
                    });

                    // Parse the JSON response
                    const result = await response.json();

                    if (result.exists) {
                        //alert('This email already exists. Please use another one.');
                        document.getElementById('emailError').innerHTML = `
                        <div class="english" style="color: red">This email is exists, please select another one</div>
                        <div class="arabic" style="color: red">الايميل مستخدم سابقاً, من فضلك استعمل ايميل اخر</div>
                        `;
                        event.preventDefault();
                    } else {
                        // Email doesn't exist, submit the form
                        //alert('Email is available. Submitting the form...');
                        //event.preventDefault();
const formData = new FormData(event.target);

const response = await fetch('<?php echo $clientdirectory; ?>/make_reservation.php', {
method: 'POST',
body: formData
});

const result = await response.text();
//alert(result);
myForm.style.display = "none";
document.getElementById('reservation-menu').style.overflow="visible";

document.getElementById('reservationForm2').style.visibility = "hidden";
document.getElementById('reservationForm2').style.height = "0";

fetchReservations();
document.getElementById('form_result').innerHTML = result;
document.getElementById('makereservationtitle').innerHTML = `<div class="english">Thank You</div><div class="arabic">شكراً علي حجزك</div>`;

                        //form.submit();
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again later.');
                }

<?php //} ?>
/**/
<?php //if(!$_SESSION['user_id']){ ?>
event.preventDefault();
<?php //} ?>


    
    
    
    
    

}
});
</script>































<?php }
    ?>
    <div id="form_result"></div>
    </div>
    </div>

















    <div style="display: flex ; justify-content: space-between; align-items: center; direction: ltr !important">
        <div class="reservation-btn" style="margin : 0; height: fit-content">
            <button class="popup-trigger" onclick="window.location.href='https://tourapp.tech'">
                <div class="english">Join Tour</div>
                <div class="arabic">انضم الى تور</div>
            </button>
        </div>
    
        <button id="close-slide-up" style="font-size: 16px"><div class="english">Close</div><div class="arabic">اغلاق</div></button>
    </div>


</div>
</div>




















































<input type="checkbox" id="sidebar-toggle" />
<label for="sidebar-toggle" class="sidebar-overlay"></label>

<div class="sidebar">
  <p><strong>Sidebar Menu</strong></p>
  <ul>
    <li><a href="#">Link 1</a></li>
    <li><a href="#">Link 2</a></li>
    <li><a href="#">Link 3</a></li>
  </ul>
</div>

<label for="sidebar-toggle" class="sidebar-open-btn">☰ Menu</label>

<style>
/* Hide the checkbox */
#sidebar-toggle {
  display: none;
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  left: -250px;
  width: 250px;
  height: 100%;
  background: #222;
  color: white;
  padding: 20px;
  box-shadow: 2px 0 10px rgba(0,0,0,0.3);
  transition: left 0.3s ease;
  z-index: 1001;
}

/* Overlay (label that acts as backdrop) */
.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.4);
  display: none;
  z-index: 1000;
  cursor: pointer;
}

/* Open button */
.sidebar-open-btn {
  cursor: pointer;
  padding: 10px 20px;
  background: #333;
  color: white;
  font-size: 18px;
  display: inline-block;
  position: absolute;
  z-index: 999;
right: 0;
bottom: 0
}

/* Show sidebar and overlay when checkbox is checked */
#sidebar-toggle:checked ~ .sidebar {
  left: 0;
}

#sidebar-toggle:checked ~ .sidebar-overlay {
  display: block;
}


</style>

</div>
    <script type="module">
      import { connect } from 'MP_SDK';
      (async function connectSdk() {
        const iframe = document.getElementById('showcase-iframe');

        // connect the sdk; log an error and stop if there were any connection issues
        try {
          const mpSdk = await connect(iframe);
          onShowcaseConnect(mpSdk);
        } catch (e) {
          console.error(e);
        }
      })();

      async function onShowcaseConnect(mpSdk) {
        // insert your sdk code here. See the ref https://matterport.github.io/showcase-sdk//docs/reference/current/index.html



















/**/
mpSdk.Mattertag.getData().then(tags => {
tags.forEach(tag => {
mpSdk.Tag.allowAction(tag.sid, {
navigating: true,
opening: false,
docking: false
});
});
}).catch(error => {
console.error('Error modifying tags:', error);
});
/**/
    
    
    
    
    
    
    




    
    
    
    
    
    
    
/**/

mpSdk.Mattertag.getData().then(tags => {
    
    
    
        tags.forEach(item => {
  item.enabled = false;
   item.label = "teste";
});
    
    
    console.log('test', tags);
    

}).catch(error => {
    console.error('Error getting Mattertag data:', error);
});

/**/


// Fetch Mattertag data and display in a custom container
mpSdk.Mattertag.getData().then(tags => {
    tags.forEach(tag => {
        //console.log('Tag Label:', tag.label);

        // Replace mediaSrc links for embedding
        let vidurl = '';
        if (tag.mediaSrc.includes("watch?v=")) {
            vidurl = tag.mediaSrc.replace("watch?v=", "embed/");
        } else if (tag.mediaSrc.includes("com/album")) {
            vidurl = tag.mediaSrc.replace("com/album", "com/embed/album");
        }

        // Dynamically update a custom HTML container with tag details
/*        document.querySelector('.food-slideup-container').innerHTML += `
            ${tag.label}<br>${tag.description}<br>
            <embed src="${vidurl}" width="100%" height="200"></embed><br><br>
        `;
        */
        //console.log('Tag Description:', tag.description);
        //console.log('Tag Media Source:', tag.mediaSrc);
    });
}).catch(error => {
    console.error('Error getting Mattertag data:', error);
});

// Create a fixed container for video label display
const videotest = document.createElement('div');
videotest.id = 'video-label-container';
videotest.style.position = 'absolute';
videotest.style.width = "clamp(200px, 90%, 550px)";
videotest.style.top = '5%';
videotest.style.left = '5%';
videotest.style.right = '5%';
videotest.style.backgroundColor = 'rgba(0,0,0,0.7)';
videotest.style.color = 'white';
videotest.style.padding = '80px 30px 40px';
videotest.style.borderRadius = '16px';
videotest.style.zIndex = '1000';
videotest.style.display = 'none'; // Initially hidden
document.getElementById('container').appendChild(videotest);

// Subscribe to tag changes and update video-label-container on selection
mpSdk.Tag.openTags.subscribe({
    prevState: {
        hovered: null,
        docked: null,
        selected: null,
    },
    onChanged(newState) {

        if (newState.hovered !== this.prevState.hovered) {
            if (newState.hovered) {
                console.log(newState.hovered, 'was hovered');
            } else {
                console.log(this.prevState.hovered, 'is no longer hovered');
            }
        }
        if (newState.docked !== this.prevState.docked) {
            if (newState.docked) {
                console.log(newState.docked, 'was docked');
            } else {
                console.log(this.prevState.docked, 'was undocked');
            }
        }

        // Handle selected tags
        const [selected = null] = newState.selected;
        if (selected !== this.prevState.selected) {
            if (selected) {
                console.log(selected, 'was selected');

                // Fetch the Mattertag data for the selected tag
                mpSdk.Mattertag.getData().then(tags => {
                    const selectedTag = tags.find(tag => tag.sid === selected);

                    if (selectedTag) {
                        

                        
/*
                        console.log('Selected Tag Info:');
                        console.log('Label:', selectedTag.label);
                        console.log('Description:', selectedTag.description);
                        console.log('Media Source:', selectedTag.mediaSrc);
*/
                        let vidurl = '';
                        let imgurl = '';
                        if (selectedTag.mediaSrc.includes("watch?v=")) {
                            vidurl = selectedTag.mediaSrc.replace("watch?v=", "embed/");
                        } else if (selectedTag.mediaSrc.includes("com/album")) {
                            vidurl = selectedTag.mediaSrc.replace("com/album", "com/embed/album");
                        }
						else{
						imgurl = selectedTag.mediaSrc;
						}

                        // Update the video-label-container with tag details
                        const videoContainer = document.getElementById('video-label-container');
                        if (selectedTag.mediaSrc.includes("watch?v=")){
                        videoContainer.innerHTML = `
                            <h2>${selectedTag.label}</h2><br><p>${selectedTag.description}</p><br>
                            <iframe src="${vidurl}" width="100%" height="200" style="color-scheme: light; border-radius: 16px; border: none; height : 250px" loading="lazy" allowfullscreen></iframe><br><br>
                            <button id="close-tag" class="close-tag"><div class="english">Close</div><div class="arabic">اغلاق</div></button>
                        `;


                        } else if (selectedTag.mediaSrc.includes("com/album")) {
                        videoContainer.innerHTML = `
                            <h2>${selectedTag.label}</h2><br><p>${selectedTag.description}</p><br>
                            <iframe src="${vidurl}" width="100%" height="200" style="color-scheme: light; border-radius: 16px; border: none; height : 250px" loading="lazy" allowfullscreen></iframe><br><br>
                            <button id="close-tag" class="close-tag"><div class="english">Close</div><div class="arabic">اغلاق</div></button>
                        `;
}

						else{
                        videoContainer.innerHTML = `
                            <h2>${selectedTag.label}</h2><br><p>${selectedTag.description}</p><br>
                            <img src="${imgurl}" style="color-scheme: light; border-radius: 16px; border: none; width : 100%" loading="lazy">
                            <button id="close-tag" class="close-tag"><div class="english">Close</div><div class="arabic">اغلاق</div></button>
                        `;
						}



const closeTags = document.getElementsByClassName('close-tag');
for (let i = 0; i < closeTags.length; i++) {
  closeTags[i].onclick = () => {
    videoContainer.style.display = 'none';
    mpSdk.Tag.close(selectedTag.sid);
  };
}
                        videoContainer.style.display = 'block';
                    }
                }).catch(error => {
                    console.error('Error fetching Mattertag data for selected tag:', error);
                });
            } else {
                console.log(this.prevState.selected, 'was deselected');
                // Hide the video-label-container when no tag is selected
                document.getElementById('video-label-container').style.display = 'none';
            }
        }

        // Clone and store the new state
        this.prevState = {
            ...newState,
            selected,
        };
    },
});


/**/

































/* select tag start */
/*
mpSdk.Tag.openTags.subscribe({
  prevState: {
    hovered: null,
    docked: null,
    selected: null,
  },
  onChanged(newState) {
    if (newState.hovered !== this.prevState.hovered) {
      if (newState.hovered) {
        console.log(newState.hovered, 'was hovered');
      } else {
        console.log(this.prevState.hovered, 'is no longer hovered');
      }
    }
    if (newState.docked !== this.prevState.docked) {
      if (newState.docked) {
        console.log(newState.docked, 'was docked');
      } else {
        console.log(this.prevState.docked, 'was undocked');
      }
    }

    // only compare the first 'selected' since only one tag is currently supported
    const [selected = null] = newState.selected; // destructure and coerce the first Set element to null
    if (selected !== this.prevState.selected) {
        if (selected) {
            console.log(selected, 'was selected');

document.getElementById('toggleFloorButton').style.display="none";
document.getElementById('startTourButton').style.display="none";
document.getElementById('share-menu-btn').style.display="none";
document.getElementById('food-menu-btn').style.display="none";
document.getElementById('more-btn').style.display="none";
document.getElementById('info-reservation').style.display="none";
document.getElementById('showcase-logo').style.display="none";
document.getElementById('login_menu_btn').style.display="none";


        } else {
            console.log(this.prevState.selected, 'was deselected');

document.getElementById('toggleFloorButton').style.display="flex";
document.getElementById('startTourButton').style.display="flex";
document.getElementById('share-menu-btn').style.display="flex";
document.getElementById('food-menu-btn').style.display="flex";
document.getElementById('more-btn').style.display="flex";
document.getElementById('info-reservation').style.display="flex";
document.getElementById('showcase-logo').style.display="flex";
document.getElementById('login_menu_btn').style.display="flex";

        }
    }

    // clone and store the new state
    this.prevState = {
      ...newState,
      selected,
    };
  },
});
*/
/* select tag end */


















/* sweep transition function */
/*
  let previousSweep = null;
  let transitionCount = 0;

  mpSdk.Sweep.current.subscribe((currentSweep) => {
    if (previousSweep && currentSweep !== previousSweep) {
      transitionCount += 1;
      console.log(`Transition #${transitionCount}: ${previousSweep} -> ${currentSweep}`);
if (transitionCount >= 7 && transitionCount < 8 ){document.getElementById('more-btn').classList.add('warning');}


    }
    previousSweep = currentSweep;
  });
*/
/* sweep transition function */


/* view switcher */

let currentMode = 'INSIDE';























<?php if($restaurant->have_highlight == 1){?>
document.getElementById('startTourButton').addEventListener('click', function() {


mpSdk.Tour.start()
  .then(function() {
    console.log('print this');
  })
  .catch(function(error) {
  });


});
<?php } ?>












//test from properties
<?php if($restaurant->have_floors){ ?>
document.getElementById('toggleFloorButton1').addEventListener('click', function() {
mpSdk.Floor.moveTo(0)
  .then(function(floorIndex) {
    // Move to floor complete.
    console.log('Current floor: ' + floorIndex);
  })
  .catch(function(error) {
    // Error moving to floor.
  });
});

document.getElementById('toggleFloorButton2').addEventListener('click', function() {
mpSdk.Floor.moveTo(1)
  .then(function(floorIndex) {
    // Move to floor complete.
    console.log('Current floor: ' + floorIndex);
  })
  .catch(function(error) {
    // Error moving to floor.
  });
});


<?php if (isset($restaurant->third_floor_name) && is_string($restaurant->third_floor_name) && strlen($restaurant->third_floor_name) > 3) { ?>
document.getElementById('toggleFloorButton3').addEventListener('click', function() {
mpSdk.Floor.moveTo(2)
  .then(function(floorIndex) {
    // Move to floor complete.
    console.log('Current floor: ' + floorIndex);
  })
  .catch(function(error) {
    // Error moving to floor.
  });
});
<?php } ?>


<?php } ?>



























    
const mattertagDataArray = [
    {
        id: 'test123',
        label: 'New Tag 1',
        description: 'This is the first Mattertag',
        anchorPosition: { x: -1.20, y: 1.37, z: 7.14 },
        stemVector: { x: 0, y: 0, z: 0 },
        color: { r: 0, g: 255, b: 0 },
        opacity: 0,
        extra: 'https://example.com/image1',
        media: {
            type: 'image',
            src: 'https://example.com/image1'
        }
    },
    {
        id: 'test124',
        label: 'New Tag 2',
        description: 'This is the second Mattertag',
        anchorPosition: { x: 2.30, y: -1.50, z: 4.00 },
        stemVector: { x: 0.1, y: 0.1, z: 0.1 },
        color: { r: 255, g: 0, b: 0 },
        opacity: 0.8,
        extra: 'https://example.com/image2',
        media: {
            type: 'image',
            src: 'https://example.com/image2'
        }
    },
    {
        id: 'test125',
        label: 'New Tag 3',
        description: 'This is the third Mattertag',
        anchorPosition: { x: 0.00, y: 0.00, z: 0.00 },
        stemVector: { x: 0, y: 0, z: 1 },
        color: { r: 0, g: 0, b: 255 },
        opacity: 0.5,
        extra: 'https://example.com/image3',
        media: {
            type: 'image',
            src: 'https://example.com/image3'
        }
    }
];

const result = await mpSdk.Mattertag.add([mattertagDataArray[0]]);




/* print label on click tag */

mpSdk.Tag.data.subscribe({
  onCollectionUpdated(collection) {
    const tagsContainer = document.createElement('div');
    tagsContainer.id = 'matterport-tags-container';
    tagsContainer.className = 'matterport-tags';
    
    // Convert the collection object to an array of tags
    const tags = Object.values(collection);
    
    tags.forEach(tag => {
      // Check if tag has attachments
      if (tag.attachments && tag.attachments.length > 0) {
        const tagElement = document.createElement('div');
        tagElement.className = 'matterport-tag';
        tagElement.dataset.tagId = tag.id; // Store tag ID for reference
        tagElement.innerHTML = `
          <h3>${tag.label || 'Untitled Tag'}</h3>
          <p>${tag.description || ''}</p>
          
          <div class="tag-attachments">
            ${tag.extra || '' }
          </div>
          
          
        `;
        
        tagsContainer.appendChild(tagElement);
      }
    });
    
    document.body.appendChild(tagsContainer);

    // UI elements to toggle
    const uiElementIds = [
      'toggleFloorButton',
      'startTourButton', 
      'share-menu-btn', 
      'food-menu-btn', 
      'more-btn', 
      'info-reservation', 
      'showcase-logo', 
      'login_menu_btn'
    ];

    // Create a label container
    const labelContainer = document.createElement('div');
    labelContainer.id = 'tag-label-container';
    labelContainer.style.position = 'fixed';
    labelContainer.style.top = '20px';
    labelContainer.style.left = '20px';
    labelContainer.style.right = '20px';
    labelContainer.style.backgroundColor = 'rgba(0,0,0,0.7)';
    labelContainer.style.color = 'white';
    labelContainer.style.padding = '10px';
    labelContainer.style.borderRadius = '5px';
    labelContainer.style.zIndex = '1000';
    labelContainer.style.display = 'none';

    document.body.appendChild(labelContainer);
    

    // Tag selection handler
    mpSdk.Tag.openTags.subscribe({
      prevState: {
        hovered: null,
        docked: null,
        selected: null,
      },
      
      onChanged(newState) {
        // Destructure and handle selected state (first element of the set)
        const [selected = null] = newState.selected;
        
        if (selected !== this.prevState.selected) {
          if (selected) {
              mpSdk.Tag.toggleDocking(false);
              const docked = null;
            // When a tag is selected
            console.log(selected, 'was selected');
            
            // Hide UI elements
            uiElementIds.forEach(id => {
              const element = document.getElementById(id);
              if (element) {
                element.style.display = 'none';
              }
            });
            
            // Find and display tag label
            const selectedTagElement = document.querySelector(`.matterport-tag[data-tag-id="${selected}"]`);
            if (selectedTagElement) {
              const tagLabel = selectedTagElement.querySelector('h3').textContent;
              const tagDesc =  selectedTagElement.querySelector('p').textContent;
              const labelContainer = document.getElementById('tag-label-container');
              labelContainer.innerHTML = "<h2>" + tagLabel + "</h2><br><p>" + tagDesc + "</p>";
              labelContainer.style.display = 'none';
              console.log('yes one')
              
            }
          } else {
            // When a tag is deselected
            console.log(this.prevState.selected, 'was deselected');
            
            // Restore UI elements
            uiElementIds.forEach(id => {
              const element = document.getElementById(id);
              if (element) {
                element.style.display = 'flex';
              }
            });
            
            // Hide label container
            const labelContainer = document.getElementById('tag-label-container');
            labelContainer.style.display = 'none';
          }
        }
        
        // Clone and store the new state
        this.prevState = {
          ...newState,
          selected,
        };
      },
    });
  }
});

// Optional CSS for styling
const style = document.createElement('style');
style.textContent = `
  .matterport-tags {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background-color: rgba(0,0,0,0.7);
    color: white;
    padding: 10px;
    border-radius: 5px;
    max-width: 300px;
    display: none;
    height : 500px;
    overflow: scroll;
  }
  .matterport-tag {
    margin-bottom: 10px;
  }
  .tag-attachments img {
    max-width: 100px;
    margin: 5px;
  }
  #close-tag {
    background: white;
    color: black;
    display: flex;
    align-items: cemter;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    border-radius: 50px;
    position: absolute;
    top: 20px;
    right: 20px;}
`;
document.head.appendChild(style);


















        // try retrieving the model data and log the model's sid
        try {

        // Get floors
          console.log('Hello SDK', mpSdk);
          const modelData = await mpSdk.Model.getData();
          console.log('Model sid:' + modelData.sid);
        } catch (e) {
          console.error(e);
        }
      }
    </script>








<?php

/*
global $wpdb;
$restaurants = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rs_restaurants");


foreach ($restaurants as $r) {
    echo "<h3>$r->name</h3>";
    echo "<p>$r->description</p>";
    echo "<p>Location: $r->location</p>";
    echo "<p>Phone: $r->phone</p>";
    echo "<hr>";
}



$id = 1;  
$restaurant = $wpdb->get_row(
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}rs_restaurants WHERE restaurant_id = %d", $id)
);

echo $restaurant->name;
echo $restaurant->tour_id;
echo $restaurant->email;
echo $restaurant->location;




$users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rs_users");

foreach ($users as $u) {
    echo "<h4>$u->name ($u->user_type)</h4>";
    echo "<p>Email: $u->email</p>";
}




global $wpdb;

$reservations = $wpdb->get_results("
    SELECT r.*, 
           u.name AS user_name,
           re.name AS restaurant_name
    FROM {$wpdb->prefix}rs_reservations r
    JOIN {$wpdb->prefix}rs_users u 
        ON r.user_id = u.user_id
    JOIN {$wpdb->prefix}rs_restaurants re 
        ON r.restaurant_id = re.restaurant_id
");

foreach ($reservations as $res) {
    echo "<h3>Reservation #$res->reservation_id</h3>";
    echo "User: $res->user_name<br>";
    echo "Restaurant: $res->restaurant_name<br>";
    echo "Date: $res->reservation_date<br>";
    echo "Time: $res->reservation_time<br>";
    echo "Status: $res->status<br>";
    echo "<hr>";
}




$food = $wpdb->get_results("
    SELECT f.*, r.name AS restaurant_name
    FROM {$wpdb->prefix}rs_food f
    JOIN {$wpdb->prefix}rs_restaurants r 
    ON f.restaurant_id = r.restaurant_id
");

foreach ($food as $f) {
    echo "<h3>$f->name</h3>";
    echo "<p>Restaurant: $f->restaurant_name</p>";
    echo "<p>Category: $f->category</p>";
    echo "<p>Price: $f->price</p>";
    echo "<img src='$f->image' width='100'>";
    echo "<hr>";
}
*/



?>





<script>



const btn = document.getElementById('fullscreenBtn');
const container = document.getElementById('container');

function toggleFullscreen() {

if (!document.fullscreenElement) {

container.requestFullscreen().catch(err => {
alert(`Error attempting to enable fullscreen: ${err.message}`);
});

<?php if($restaurant->have_floors == 1){?>
document.getElementById('toggleFloorButton').style.display="none";
<?php } ?>
<?php if($restaurant->have_highlight == 1){?>
document.getElementById('startTourButton').style.display="none";
<?php } ?>
document.getElementById('share-menu-btn').style.display="none";
<?php if($restaurant->have_food_menu == 1){?>
document.getElementById('food-menu-btn').style.display="none";
<?php } ?>

<?php if ($restaurant->reservation != 2){ ?>
document.getElementById('more-btn').style.display="none";
document.getElementById('login_menu_btn').style.display="none";
<?php } ?>

document.getElementById('info-reservation').style.display="none";
document.getElementById('showcase-logo').style.display="none";

}

else {
document.exitFullscreen();
<?php if($restaurant->have_floors == 1){?>
document.getElementById('toggleFloorButton').style.display="flex";
<?php } ?>
<?php if($restaurant->have_highlight == 1){?>
document.getElementById('startTourButton').style.display="flex";
<?php } ?>
document.getElementById('share-menu-btn').style.display="flex";
<?php if($restaurant->have_food_menu == 1){?>
document.getElementById('food-menu-btn').style.display="flex";
<?php } ?>

<?php if ($restaurant->reservation != 2){ ?>
document.getElementById('more-btn').style.display="flex";
document.getElementById('login_menu_btn').style.display="flex";
<?php } ?>

document.getElementById('info-reservation').style.display="flex";
document.getElementById('showcase-logo').style.display="flex";

}

}

btn.addEventListener('click', toggleFullscreen);

// Optional: Detect when fullscreen mode changes
/*
document.addEventListener('fullscreenchange', () => {
if (document.fullscreenElement) {
btn.textContent = 'Exit Fullscreen';
} else {
btn.textContent = 'Go Fullscreen';
}
});
*/
</script>






  </body>
</html>
