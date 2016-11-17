<?php
// no direct access
defined('_JEXEC') or die;
$orderId = JRequest::getVar('orderid');
$db = JFactory::getDBO();
$q = "SELECT * FROM #__booking WHERE id = ".$orderId;
$db->setQuery($q);
$order = $db->loadObject();

//$merchant = '6284736'; // real
$merchant = '8024585'; // test
?>
<form action="https://ssl.ditonlinebetalingssystem.dk/integration/ewindow/Default.aspx" method="post" id="paymetForm">
    <input type="hidden" name="merchantnumber" value="<?php echo $merchant;?>">
    <input type="hidden" name="amount" value="<?php echo $order->total_da*100;?>">
    <input type="hidden" name="currency" value="DKK">
    <input type="hidden" name="windowstate" value="3">
    <input type="hidden" name="orderid" value="<?php echo sprintf("%05d", $orderId);?>">
    <input type="hidden" name="accepturl" value="<?php echo JURI::base();?>index.php?option=com_booking&task=paymentSuccess&orderid=<?php echo $orderId;?>">
    <input type="hidden" name="cancelurl" value="<?php echo JURI::base();?>index.php?option=com_booking&view=home&layout=fail">
</form>
<script type="application/javascript">
jQuery( document ).ready(function() {
	jQuery("#paymetForm").submit();
});
</script>