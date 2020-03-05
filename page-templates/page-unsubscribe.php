<?php 
/* Template Name: Unsubscribe */
get_header();

global $wpdb;

$id = $_GET['id'];
$email = $_GET['email'];
$table = 'subscribe';
$wpdb->delete($table, array('id' => $id));
if(!$id){
    get_template_part('404');
}
?>
<section id="content">
    <div class="container">
        <div class="row">
            <div id="region-aux1" class="col-xs-12 col-md-12">
                <div class="success" role="alert">
                            <h2>You have successfully unsubscribed</h2>
                        <p><?= 'You\'ll be redirected in about 5 secs. If not, click <a href="https://medicine.iu.edu/news/">here</a>.'; ?></p>

                </div>

            </div>
        </div><!-- row -->
        </div><!-- container -->
</section>

<script>
setTimeout(function(){
            window.location.href = 'https://medicine.iu.edu/news/';
         }, 5000);
</script>
<?php
get_footer();

?>