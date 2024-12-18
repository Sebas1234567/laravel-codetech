
var o = { 
	"selectors": { "block": "pre", "inline": "code" }, 
	"options": { 
		"indent": 2, 
		"ampersandCleanup": true, 
		"linehover": true, 
		"rawcodeDbclick": false, 
		"textOverflow": "scroll", 
		"linenumbers": true, 
		"theme": "atomic", 
		"language": "generic", 
        "retainCssClasses": false, 
		"collapse": false, 
		"toolbarOuter": "", 
		"toolbarTop": "{BTN_RAW}{BTN_COPY}{BTN_WINDOW}{BTN_WEBSITE}", 
		"toolbarBottom": "" 
	} 
}; 
EnlighterJS.init(o.selectors.block, o.selectors.inline, o.options);