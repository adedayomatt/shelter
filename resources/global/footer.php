<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/js/jquery.min.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/bootstrap/js/bootstrap.min.js' ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo $root.'/resources/js/suggest_property.js' ?>"></script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});


$(function () {
  $('[data-toggle="popover"]').popover();
});
</script>
<?php
 $now = time();
//update last seen
if($status == 1 || $status==9){

if($status==1){
$update_last_seen = $db->query_object("UPDATE profiles SET last_seen = $now WHERE  token='".$_COOKIE['user_agent']."' ");
}
else if($status==9){
$update_last_seen = $db->query_object("UPDATE cta SET last_seen = $now WHERE  token='".$_COOKIE['user_cta']."' ");
}

if($connection->affected_rows == 1){
    echo "last seen updated";
}
else{
    echo "last seen update failed";
}
}

//close mysqli connection
$db->close_connection();
?>
<style>
#footer{
   display:none;
background-color:black;
opacity:0.8;
color:white;
border: 5px;
text-align:center;
padding:10px;
}
</style>
<div id="footer">
Footer will appear here
</div>
