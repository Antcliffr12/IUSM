<?php
if(!empty($_POST)){
  global $wpdb;
  // $name = $_POST['contactname'];
  // $address = $_POST['address'];
  //  $program_name = $_POST['program_name'];
  // $specialty = $_POST['specialty'];
  // $transitionyear = $_POST['transitionyear'];

  $table_name = $wpdb->prefix . 'markers';
  $data = array(
    'contactname' => $_POST['contactname'],
    'address' => $_POST['address'],
    'program_name' => $_POST['program_name'],
    'specialty' => $_POST['specialty'],
    'transitionyear' => $_POST['transitionyear'],
  );
  $format = array(
    '%s',
    '%s',
    '%s',
    '%s',
    '%s',

  );
  $success = $wpdb->insert($table_name, $data, $format);
  if($success){
    ?>
    <script type="text/javascript">
    //document.location.href="http://localhost:8080/multisite/match-day-map/";
          //document.location.href="http://devwp.medicine.iu.edu/match-day-map/";
          document.location.href="<?= site_url('match day map')?>";

    </script>
    <?php


  }else{

  }
}else{
 ?>

<form method="POST" id="entryform">

     <div id="name-group" class="form-group">
         <label for="contactname">Name</label>
         <input type="text" class="form-control" name="contactname" placeholder="Full Name">
     </div>

     <div id="matchaddress" class="form-group">
         <label for="address">Matched Location</label>
         <input type="text" class="form-control" name="address" placeholder="City, State">
     </div>

     <div id="programname" class="form-group">
         <label for="program_name">Program Name</label>
         <input type="text" class="form-control" name="program_name" placeholder="Example: Indiana University">
     </div>

     <div id="specialty" class="form-group" autocomplete="off">
         <label for="specialty">Matched Specialty</label>
         <input type="text" id="matched" list="xml-datalist" class="form-control" name="specialty" placeholder="Example: Pediatric Surgery">
         <datalist id="xml-datalist"></datalist>
     </div>

     <div id="transitional" class="form-group">
         <label for="transitional">Transitional Year City, State (optional)</label>
         <input type="text" class="form-control" name="transitionyear" placeholder="example: Denver, CO">
     </div>

     <button type="submit" class="btn btn-success">Submit <span class="fa fa-arrow-right"></span></button>
     <button type="reset" class="btn btn-danger">Reset Form<span class="fa fa-arrow-right"></span></button>

 </form>
<?php } ?>
