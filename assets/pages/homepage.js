$('#game_strategy').change(compute)
$('#game_condition').change(compute)
$('#game_floor').change(compute)

function compute() {
    const strategy = parseInt($('#game_strategy').val())
    const condition = parseInt($('#game_condition').val())
    const floor = Math.trunc(($('#game_floor').val() || 0) * 100)

    fetch('/api/compute', {
        method: 'POST',
        headers: new Headers({'Content-Type': 'application/json', 'Accept': 'application/json'}),
        body: JSON.stringify({
            'strategy': strategy, 'condition': condition, 'floor': floor
        })
    })
    .then((response) => {
        if (response.status === 400) {
            response.json().then(response => {
                Object.keys(response).forEach((value) => {
                    $('#errors').append(value + ' - ' + response[value])
                })
            })

            return
        }
        $('#game_price').val(response.price / 100)
    }).catch(response => console.log(response))
}

