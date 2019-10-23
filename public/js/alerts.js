function fadeAlerts() {
	var alertId = (document.getElementById('alert_s')) || (document.getElementById('alert'));
	if (alertId) {
		var alert = document.getElementById(alertId.id).style;
		alert.opacity = 1;
		setTimeout(function fade() {
			(alert.opacity -= .1) < 0 ? alertId.remove() : setTimeout(fade, 30)
		}, alertId.id == 'alert_s' ? 5000 : 7500);
	}
} fadeAlerts();