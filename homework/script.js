function prepareExportData() {
    let result = [];
    
    for(let i = 0; i < 8; i++){
        const elem = document.querySelector(`input[id="ef${i}"]:checked`); 
        if(elem){
            result.push(Number(elem.value));
        }
    }

    if(result.length > 0){
        const table = document.getElementById('table');
        let csvContent = "";
    
        for (let i = 1; i < table.rows.length; i++){
            let row = table.rows.item(i).cells;
            let csvRow = "";

            for(var j = 0; j < row.length; j++){
                if(result.includes(j)){
                    let cell = row.item(j).innerHTML;
                    csvRow += `${cell},`;
                }
            }

            csvRow = csvRow.substring(0, csvRow.length - 1);
            csvRow += '\n';
            csvContent += csvRow;
        }

        var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement("a");

        if (link.download !== undefined) {
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", "exported_data.csv");
            link.style.visibility = 'hidden';
            document.getElementById('aside').appendChild(link);
            link.click();
            document.getElementById('aside').removeChild(link);
        }
    }
}

var modal = document.getElementById("myModal");
var btn = document.getElementById("pcButton");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}