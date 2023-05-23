document.addEventListener("DOMContentLoaded", function() {

	setTimeout(function() {

		let targetDiv = document.querySelector(cynosureSettings.selector);

		if ( cynosureSettings.debug ) {
			console.log( "[Cynosure] Target Selector:", cynosureSettings.selector );
			console.log( "[Cynosure] Target Div Contents:", targetDiv );
		}

		if ( targetDiv ) {
			function cynosure() {
				let windowMid = window.scrollY + window.innerHeight / 2;
				let rect = targetDiv.getBoundingClientRect();
				let divTop = rect.top + window.pageYOffset;
				let divBottom = divTop + targetDiv.offsetHeight;

				if (divTop <= windowMid + 0 && divBottom >= windowMid) {
					if ( ! targetDiv.classList.contains('cynosure-active') ) {
						targetDiv.classList.add('cynosure-active');
						if ( cynosureSettings.debug ) {
							console.log("[Cynosure] Activated - windowMid: ", windowMid, ". divTop: ", divTop, ". divBottom: ", divBottom);
						}
					}
				} else {
					if (targetDiv.classList.contains('cynosure-active')) {
						targetDiv.classList.remove('cynosure-active');
						if ( cynosureSettings.debug ) {
							console.log("[Cynosure] Deactivated - windowMid: ", windowMid, ". divTop: ", divTop, ". divBottom: ", divBottom);
						}
					}
				}
			}

			let ticking = false;

			document.addEventListener("scroll", (event) => {
				if (!ticking) {
					window.requestAnimationFrame(() => {
						cynosure();
						ticking = false;
					});

					ticking = true;
				}
			});

		} else {
			console.log("[Cynosure] Target div", cynosureSettings.selector, "not found");
		}

	}, 2000);

});
