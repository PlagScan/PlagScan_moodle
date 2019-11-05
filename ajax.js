/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


M.plagiarism_plagscan = {
    reports: []
};

M.plagiarism_plagscan.init = function (Y, contextid, viewlinks, showlinks, viewreport, ps_yellow_level, ps_red_level, pageurl) {

    var handleReport = function (report) {
        var reportArea = Y.one('.psreport.pid-' + report.id);

        if (!report.content.includes('psfile_progress')) {
            reportArea.insert(report.content, 'after').remove();
            var reports = M.plagiarism_plagscan.reports;
            reports.splice(reports.indexOf(report.id), 1);
        }
    };

    var checkReportStatus = function (Y, reports, contextid, viewlinks, showlinks, viewreport, ps_yellow_level, ps_red_level, pageurl) {
        
        if (!reports[0]) {
            return;
        }

        var url = M.cfg.wwwroot + '/plagiarism/plagscan/ajax.php';

        var callback = {
            method: 'get',
            context: this,
            sync: false,
            data: {
                'sesskey': M.cfg.sesskey,
                'data': Y.JSON.stringify({
                    psreports: reports,
                    cmid: contextid,
                    viewlinks: viewlinks,
                    showlinks: showlinks,
                    viewreport: viewreport,
                    ps_yellow_level: ps_yellow_level,
                    ps_red_level: ps_red_level,
                    pageurl: pageurl
                })
            },
            on: {
                success: function (tid, response) {
                    var jsondata = Y.JSON.parse(response.responseText);

                    Y.each(jsondata, handleReport);

                },
                failure: function () {
                    M.plagiarism_plagscan.reports = [];
                }
            }
        };

        Y.io(url, callback);
    };

    Y.all(".psreport").each(function (row) {
        if (row._node.childNodes[0].className == 'psfile_progress') {
            M.plagiarism_plagscan.reports.push(row._node.classList[1].substring(4));
        }
    });

    setInterval(function () {
        checkReportStatus(Y, M.plagiarism_plagscan.reports, contextid, viewlinks, showlinks, viewreport, ps_yellow_level, ps_red_level, pageurl)
    }, 3000);
};
