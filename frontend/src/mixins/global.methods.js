const globalMethods = {
	methods: {
		yandexReachGoal(targetName) {
			const arrayUrlsToExclude = process.env.VUE_APP_URLS_TO_EXCLUDE
				? process.env.VUE_APP_URLS_TO_EXCLUDE.split(",")
				: [];
			const currentUrl = location.origin;
			const counterNumber = "55975672";

			if (
				process.env.NODE_ENV == "production" &&
				!arrayUrlsToExclude.includes(currentUrl)
			) {
				window.ym(counterNumber, "reachGoal", targetName);
			}
		},
		googleReachGoal(targetName) {
			const arrayUrlsToExclude = process.env.VUE_APP_URLS_TO_EXCLUDE
				? process.env.VUE_APP_URLS_TO_EXCLUDE.split(",")
				: [];
			const currentUrl = location.origin;

			if (
				process.env.NODE_ENV == "production" &&
				!arrayUrlsToExclude.includes(currentUrl)
			) {
				/* eslint-disable-next-line */
				gtag("event", targetName);
			}
		},
		/**
		 * Copy a string to clipboard
		 * @param  {String} string         The string to be copied to clipboard
		 * @return {Boolean}               returns a boolean correspondent to the success of the copy operation.
		 */
		copyToClipboard(string) {
			let textarea;
			let result;

			try {
				textarea = document.createElement("textarea");
				textarea.setAttribute("readonly", true);
				textarea.setAttribute("contenteditable", true);
				textarea.style.position = "fixed"; // prevent scroll from jumping to the bottom when focus is set.
				textarea.value = string;

				document.body.appendChild(textarea);

				textarea.focus();
				textarea.select();

				const range = document.createRange();
				range.selectNodeContents(textarea);

				const sel = window.getSelection();
				sel.removeAllRanges();
				sel.addRange(range);

				textarea.setSelectionRange(0, textarea.value.length);
				result = document.execCommand("copy");
			} catch (err) {
				console.error(err);
				result = null;
			} finally {
				document.body.removeChild(textarea);
			}

			// manual copy fallback using prompt
			if (!result) {
				const isMac = navigator.platform.toUpperCase().indexOf("MAC") >= 0;
				const copyHotkey = isMac ? "⌘C" : "CTRL+C";
				result = prompt(`Press ${copyHotkey}`, string); // eslint-disable-line no-alert
				if (!result) {
					return false;
				}
			}
			return true;
		}
	}
};
export default globalMethods;
