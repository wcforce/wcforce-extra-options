/**
 * React method being called from React App
 * Created date: November 25, 2022
 **/
/* global jQuery, ajaxurl, wcforce_vars*/


function wcforce_save_extra_fields(fields, callback) {
    const data = { action: "wcforce_save_extra_fields", fields: fields };
    const url = `${wcforce_vars.api_url}/save_extra_fields`;
    jQuery.post(url, data, function (resp) {
      callback(resp);
    });
}