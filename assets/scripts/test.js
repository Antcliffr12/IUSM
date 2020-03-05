// jQuery(function () {
//     jQuery('#event_id_from_list').change(function() {
//         var event = jQuery("#event_id_from_list").val();
//         var data = "event_id=" + event;
//         jQuery.ajax({
//             url: "http://localhost:8080/iusm/wp-admin/admin-ajax.php",
//             type: 'GET',
//             data: {
//               action: 'event_id'
//             },
//             success: function(data){
//                 jQuery('#div_race_type').html(data);
//
//                 console.log("success" + "" + data);
//             },
//             error:function (error ){
//               console.log("error");
//             }
//         });
//     });
// });

// jQuery('#newCustomerForm').submit(ajaxSubmit);
//
// function ajaxSubmit(){
//
//         var newCustomerForm = jQuery(this).serialize();
//
//         jQuery.ajax({
//                 type:"GET",
//                 url: "http://localhost:8080/iusm/wp-admin/admin-ajax.php",
//                 data: newCustomerForm,
//                 success:function(data){
//         jQuery("#feedback").html(data);
//                 },
//     error: function(errorThrown){
//         alert(errorThrown);
//     }
//         });
//
//         return false;
// }
