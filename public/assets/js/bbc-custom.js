(function($) { 

addClasses();

function addClasses(){

	// vars
	var os = get_operating_system(),
		browser = get_browser_info(),
		device = getDeviceType(),
		mobileOS = getMobileOS(),
		sevenInch = isSevenInch(),
		classesArray = [],
		body = jQuery('body');

	// browser name to lowercase
	browserName = browser.name;
	browserName = browserName.toLowerCase();

	// create array with classes we need
	if ( bbc_options.show_device_type == 1 ) classesArray.push(device);
	if ( bbc_options.show_os_type == 1 ) classesArray.push(mobileOS, os);
	if ( bbc_options.show_browser_type == 1 ) classesArray.push(browserName);
	if ( bbc_options.show_browser_version == 1 ) var browserVersion = browserName+browser.version; classesArray.push(browserVersion);
	if ( bbc_options.show_seven_inch == 1 ) classesArray.push(sevenInch);

	// filter empty values
	classesArray = classesArray.filter(Boolean);

	for (i = 0; i <= classesArray.length; i++) {
	    body.addClass(classesArray[i]);
	}

	detectOrientation();
	
}

function get_browser_info(){
	var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
	if(/trident/i.test(M[1])){
		tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
		return {name:'IE',version:(tem[1]||'')};
	}   
	if(M[1]==='Chrome'){
		tem=ua.match(/\bOPR\/(\d+)/)
		if(tem!=null)   {return {name:'Opera', version:tem[1]};}
	}   
	M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
	if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
	return {
		name: M[0],
		version: M[1]
	};
}

function get_operating_system(){

	var OSName="";

	if(!isMobile.any){
		if (navigator.appVersion.indexOf("Win")!=-1) OSName="windows";
		if (navigator.appVersion.indexOf("Mac")!=-1) OSName="mac";
		if (navigator.appVersion.indexOf("X11")!=-1) OSName="unix";
		if (navigator.appVersion.indexOf("Linux")!=-1) OSName="linux";
	} 

	return OSName;

}


function getDeviceType(){

	var deviceType = '';

	if(!isMobile.any) deviceType="desktop";
	if(isMobile.tablet) deviceType="tablet";
	if (isMobile.phone) deviceType="phone";

	return deviceType;

}


function getMobileOS(){

	var mobileOS ='';

	if(isMobile.any){
		if(isMobile.android.device) mobileOS = "android";
		if(isMobile.apple.device) mobileOS = "ios";
		if(isMobile.windows.device) mobileOS = "windows-phone";
		if(isMobile.amazon.device) mobileOS = "amazon";
	}
	
	return mobileOS;
}


function isSevenInch(){

	var isSevenInch ='';

	if(isMobile.seven_inch) isSevenInch = 'seven-inch';
	
	return isSevenInch;

}


function detectOrientation(){

	if(isMobile.any){

		var mm = window.matchMedia("(orientation: portrait)"),
			body = $('body');
			orientation,
			changed ='';

		// If there are matches, we're in portrait
		if(mm.matches) {  
			body.addClass('portrait');
		} else {  
			body.addClass('landscape');
		}

		// Add a media query change listener
		mm.addListener(function(m) {
			if(m.matches) {
				body.removeClass('landscape');
				body.addClass('orientation-changed portrait');
			}
			else {
				body.removeClass('portrait');
				body.addClass('orientation-changed landscape');
			}
		});

		return orientation;

	}

}

})(jQuery);