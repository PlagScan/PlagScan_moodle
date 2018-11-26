/**
 *
 * @package   plagiarism_plagscan
 * @copyright 2011 onwards Anuj Dalal  {@link http://zestard.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function submit_plagscan(url, repeat) {
    var strURL = url;

    if(repeat == 1) {
	if(window.confirm('Document is already scanned to plagscan...\n Are you sure you want to scan it again?')) {
	    alert("your document is being submitted to plagscan... please wait...");
    	    xmlhttpPost(strURL);
	}
    } else {
	alert("your document is being submitted to plagscan... please wait...");
	xmlhttpPost(strURL);
    }

    return false;
}

function xmlhttpPost(strURL) {
    var xmlHttpReq = false;
    var self = this;

    // Mozilla/Safari
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }

    self.xmlHttpReq.open('POST', strURL, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    self.xmlHttpReq.onreadystatechange = function() {
        if (self.xmlHttpReq.readyState == 4) {
            updatepage(self.xmlHttpReq.responseText);
        }
    }
    self.xmlHttpReq.send(getquerystring());
}

function getquerystring() {
    //var form = document.forms['f1'];
    //var word = form.word.value;
    //qstr = 'w=' + escape(word); // NOTE: no '?' before querystring
    return '';
}

function updatepage(str) {
    alert(str);
    window.location.reload( true );
}

