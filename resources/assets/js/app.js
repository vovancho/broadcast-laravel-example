/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Echo.channel('public')
    .listen('.task.iterate', (e) => {
        // console.log(e);

        let $tdKey = $('td.id[id="' + e.task.id + '"]');
        let $pb = $tdKey.nextAll(".percent").find(".progress .progress-bar");
        let $cancelButton = $tdKey.nextAll(".buttons").find("button.cancel");

        $tdKey.nextAll(".status").html(e.task.status_with_badge);

        $pb.attr("style", "width: " + e.task.percent + "%")
            .attr("aria-valuenow", e.task.percent)
            .attr("class", e.task.status_progressbar_class)
            .text(e.task.percent + "%");

        $.inArray(e.task.status, ['in queue', 'execute']) < 0
            ? $cancelButton.addClass('d-none')
            : $cancelButton.removeClass('d-none');
    })
    .listen('.task.cancel', (e) => {
        let $tdKey = $('td.id[id="' + e.task.id + '"]');
        let $pb = $tdKey.nextAll(".percent").find(".progress .progress-bar");
        let $cancelButton = $tdKey.nextAll(".buttons").find("button.cancel");

        $tdKey.nextAll(".status").html(e.task.status_with_badge);
        $pb.attr("class", e.task.status_progressbar_class);
        $cancelButton.addClass('d-none');
        $cancelButton.attr("disabled", false);
    });

$(".cancel").on('click', function (e) {
    $(this).attr("disabled", true);

    axios.post(route('task.cancel', $(this).attr("task-id")))
        .catch(function (response) {
            $(this).attr("disabled", false);
            console.error(response);
        });
});