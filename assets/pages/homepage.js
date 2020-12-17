$('#game_strategy').change(compute)
$('#game_condition').change(compute)
$('#game_floor').change(compute)

function compute() {
    const strategy = $('#game_strategy').val()
    const condition = $('#game_condition').val()
    const floor = Math.trunc(($('#game_floor').val() || 0) * 100)

    $.post('/api/compute', { 'strategy': strategy, 'condition': condition, 'floor': floor }).then((response) => {
        $('#game_price').val(response.price / 100)
    });
}

