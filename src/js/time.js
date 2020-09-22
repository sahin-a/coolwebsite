		function getTime() {			
			date = new Date();
			var h = date.getHours();
			var m = date.getMinutes();
			var s = date.getSeconds();
		
			return date.getHours() + " : " + date.getMinutes() + " : " + date.getSeconds();
		}