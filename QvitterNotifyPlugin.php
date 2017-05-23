<?php
if(!defined('GNUSOCIAL')){ exit(1); }
class QvitterNotifyPlugin extends Plugin{

	public function initialize(){
		return true;
	}
	public function onQvitterEndShowScripts($input){
		$js = Plugin::staticPath('QvitterNotify', '');
		$sn = common_config('site','name');
		$qp = Plugin::staticPath('Qvitter', '');
		print '<script src="'.$js.'/js/push.js/push.min.js"></script>';
		echo '';
		?>
		<script>
		var hold = '';
			//Need to hook into Qvitter notifications...
			//window.sL.newNotifications
			$( document ).ready(function() {
				//console.log( "ready!" );
				window.setInterval(needPush, 3000);
			});
		function needPush(){
			if(!Push.Permission.has()){
				Push.Permission.request();
			}
			if(document.getElementById("unseen-notifications") === 'undefined' || document.getElementById("unseen-notifications") === null){
				return;
			}
			var nPush = document.getElementById("unseen-notifications").innerHTML;
			if(hold == nPush){
				//console.log("No notifications...");
				return;
			} else {
				console.info(nPush);
				//Need to PUSH now.
				//Push.create("You have " + nPush + " new notifications on <?php echo $sn; ?>!");
				Push.create("From <?php echo $sn; ?>", {
				    body: 'You have ' + nPush + ' new notifications!',
				    icon: {
				        x16: '<?php echo $qp; ?>img/gnusocial-favicons/favicon-16x16.png',
				        x32: '<?php echo $qp; ?>img/gnusocial-favicons/favicon-32x32.png'
				    },
				    timeout: 8000
				});
				hold = nPush;
			}
		}
		</script>
		<?php
	}


}
?>
