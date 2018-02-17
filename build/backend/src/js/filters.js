import Vue from 'vue';
import moment from 'moment';

Vue.filter('humanizeFileSize', function(bytes, decimals) {
    if (bytes === 0) {
        return '0 Bytes';
    }
    let k = 1024,
        dm = decimals || 0,
        sizes = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
});

Vue.filter('humanizeDate', function(date) {
   let d = moment.utc(date);
   let now = moment.utc();
   let diffHours = d.diff(now, 'hours');
   return (diffHours * -1) > 24 ? d.local().format('MMM Do, YYYY h:mm a') : d.fromNow();
});