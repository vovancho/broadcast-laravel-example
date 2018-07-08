<template>
    <div>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>№</th>
                <th class="d-none">id</th>
                <th>Дата</th>
                <th>Задача</th>
                <th>Статус</th>
                <th>Процент выполнения</th>
                <th style="width: 100px"></th>
            </tr>
            </thead>
            <tbody class="tasks-body">
            <tr v-for="(task, key) in tasks.data" :key="task.id">
                <td>
                    {{ key + ((tasks.current_page - 1) * tasks.per_page) + 1 }}
                </td>
                <td class="id d-none" :id="task.id">
                    {{ task.id }}
                </td>
                <td>
                    {{ moment(task.created_at, "YYYY-MM-DD hh:mm:ss").format("DD.MM.YYYY hh:mm:ss") }}
                </td>
                <td>
                    {{ task.name }}
                </td>
                <td class="status" v-html="task.status_with_badge">
                    {{ task.status_with_badge }}
                </td>
                <td class="percent">
                    <div class="progress" style="height: 20px;">
                        <div :class="task.status_progressbar_class"
                             role="progressbar"
                             :style="'width: ' + task.percent + '%'"
                             :aria-valuenow="task.percent" aria-valuemin="0"
                             aria-valuemax="100">{{ task.percent }}%
                        </div>
                    </div>
                </td>
                <td style="width: 100px" class="buttons">
                    <button type="button"
                            :task-id="task.id"
                            :class="'btn btn-outline-danger btn-sm cancel ' + (['in queue', 'execute'].includes(task.status) ? '' : 'd-none')"
                            @click="cancel">
                        Отменить
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: [
            'tasks'
        ],
        mounted() {
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
        },
        methods: {
            cancel: function (e) {
                let $button = $(e.target);

                $button.attr("disabled", true);

                axios.post(route('task.cancel', $button.attr("task-id")))
                    .catch(function (response) {
                        $button.attr("disabled", false);
                        console.error(response);
                    });
            }
        }
    }
</script>
