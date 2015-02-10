/**
 * Visszatér a kiválasztott tevékenységi kör azonosítókkal.
 * @returns {Array}
 */
function findJobIds(selector) {
    //return $.map($("input[id$=\"munkakor_id\"]"), function(item) {
    return $.map($(selector), function(item) {
        if (+item.value > 0) {
            return +item.value;
        } 
    });
}
/**
 * Frissíti az elvárások és feladatok autocomplete forrást.
 * @returns {void}
 */
function updateExpectationsAndTasks(jobIds, expectationsSelector, tasksSelector) {
    $.ajax({
        async: false,
        type: "POST",
        url: domain + "allashirdetes/ajax/expectationsandtasks/",
        dataType: "json",
        data: {
            jobIds: jobIds
        },
        success: function(data) {
            elvarasOptions = data['elvarasok'];
            feladatOptions = data['feladatok'];
        }
    });
    $(expectationsSelector).autocomplete("option", "source", elvarasOptions);
    $(tasksSelector).autocomplete("option", "source", feladatOptions);
}

function tevekenysegiKor( data, count ) {
    var jobs = data,
        count = +count;
    var increaseCount = function() {
        count++;
    };
    this.setData = function ( newForm, onExists, onNotExists ) {
        if (data[count] !== undefined) {
            var job = data[count], 
                keys = Object.keys( data[count] );
            onExists.call(newForm, job[keys[3]], job[keys[2]]);
        } else {
            onNotExists.call(newForm);
        }
        increaseCount();
    };
}

function sheepItJobsAfterAdd (newForm, tks, onExists, onNotExists, expSelector, tasksSelector, deleteBtnSelector) {
    newForm.find(".job-select").jobSelect({
        baseUrl: domain 
    });
    newForm.find(".job-select-name").bind("autocompletechange", function( event, ui ) {
        var jobIds = findJobIds(".job-select-id");
        if ($.isPlainObject( ui )) {
            jobIds.push(+ui.item.value);
        }
        updateExpectationsAndTasks(jobIds, expSelector, tasksSelector);
    });
    tks.setData(newForm, onExists, onNotExists );
    newForm.find(deleteBtnSelector).click(function() {
        updateExpectationsAndTasks(findJobIds(".job-select-id"), expSelector, tasksSelector);
    });
}