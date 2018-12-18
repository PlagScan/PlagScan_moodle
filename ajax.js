/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


M.plagiarism_plagscan = {
    reports : []
};

M.plagiarism_plagscan.init = function(Y, contextid) {
    
    var handleReport = function( report) {
        var reportArea = Y.one('.psreport.pid-'+report.pid);
        
        reportArea.insert(report.content, 'after').remove();
        var reports = M.plagiarism_plagscan.reports;
        reports.splice(reports.indexOf(report.pid),1);
    };
    
    var checkReportStatus = function(Y, reports, contextid) {
        
        if(!reports[0])
            return;

        var url = M.cfg.wwwroot + '/plagiarism/plagscan/ajax.php';

        var callback = {
            method: 'get',
            context: this,
            sync: false,
            data: {
                'sesskey': M.cfg.sesskey,
                'data': Y.JSON.stringify({
                    psreports: reports,
                    cmid: contextid
                })
            },
            on: {
                success: function(tid, response) {
                    var jsondata = Y.JSON.parse(response.responseText);
                    
                    Y.each(jsondata, handleReport);

                },
                failure: function() {
                    M.plagiarism_plagscan.reports = [];
                }
            }
        };

        Y.io(url, callback);
    };
        
        Y.all(".psreport").each(function(row) {
            if(row._node.childNodes[0].className == 'progress_checking')
                M.plagiarism_plagscan.reports.push(row._node.classList[1].substring(4));
        });
        
        setInterval(function() {
            checkReportStatus(Y, M.plagiarism_plagscan.reports, contextid)
        },3000);
};
