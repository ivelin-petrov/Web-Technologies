class Item {
    constructor(dataObject){
        this.provider = dataObject.provider;
        this.instance = dataObject.instance;
        this.vcpu = dataObject.vcpu;
        this.memory = dataObject.memory;
        this.storage = dataObject.storage;
        this.network = dataObject.network;
        this.price = dataObject.price;
        this.region = dataObject.region;
    }

    getHtmlElementForItemInList() {
        const ownerData = `<td class="provider">${this.provider}</td>
                           <td class="instance">${this.instance}</td>
                           <td class="vcpu">${this.vcpu}</td>
                           <td class="memory">${this.memory}</td>
                           <td class="storage">${this.storage}</td>
                           <td class="network">${this.network}</td>
                           <td class="price">${this.price}</td>
                           <td class="region">${this.region}</td>`;
    
        const lineElement = document.createElement('tr');
        lineElement.setAttribute('class', 'item');
        lineElement.setAttribute('id', this.provider);
        
        lineElement.innerHTML = ownerData;

        return lineElement;
    }
}

const displayItems = items => {
    const itemsListContainer = document.getElementById('item-container');
    itemsListContainer.innerHTML = `<tr><th onclick="UtilityFunctions.sortColumn(0)" title="click to sort this column">Provider</th>
                                        <th onclick="UtilityFunctions.sortColumn(1)" title="click to sort this column">Instance</th>
                                        <th onclick="UtilityFunctions.sortColumn(2)" title="click to sort this column">vCPUs</th>
                                        <th onclick="UtilityFunctions.sortColumn(3)" title="click to sort this column">Memory (GiB)</th>
                                        <th onclick="UtilityFunctions.sortColumn(4)" title="click to sort this column">Storage</th>
                                        <th onclick="UtilityFunctions.sortColumn(5)" title="click to sort this column">Network (Gbps)</th>
                                        <th onclick="UtilityFunctions.sortColumn(6)" title="click to sort this column">Price (USD)</th>
                                        <th onclick="UtilityFunctions.sortColumn(7)" title="click to sort this column">Region</th></tr>`;

    items.map(item => new Item(item))
        .map(item => item.getHtmlElementForItemInList())
        .forEach(itemElement => {
            itemsListContainer.appendChild(itemElement);   
        });
}

const loadItems = () => {    
    fetch('./item.php')
        .then(response => response.json())
        .then(displayItems);
}

const getDate = () => {
    const dateContainer = document.getElementById('footer');
    dateContainer.innerHTML = `<p id="footer-container">Last update: ${new Date}</p>`
}

const displayPriceDrops = items => {
    const popupBody = document.getElementById('popup-body');
    
    if(items.length > 0){

        let text = '<br>';
        
        for(let i = 0; i < items.length; i++){
            if(items[i].priceDiff > 0){
                text += `The price of cloud service instance <strong>${items[i].instance}</strong> in the <strong>${items[i].region}</strong> 
                            has gone <strong>up</strong>: <strong>${items[i].priceDiff}</strong> USD<br><br>`;
            }else{
                text += `The price of cloud service instance <b>${items[i].instance}</b> in the <b>${items[i].region}</b> 
                            has gone <b>down</b>: <b>${items[i].priceDiff}</b> USD<br><br>`;
            }
        }

        popupBody.innerHTML = text;
    }else{
        popupBody.innerHTML = `<img src="./images/cobweb.png" width="500" />`;
    }
}

const insertItems = () => {
    const file = document.getElementById("file-input").files[0];

    if(file){
        let data = { "fileName": file.name };
    
        fetch('./item.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(displayPriceDrops);
    }
}

const searchForItems = () => {
    const inst = document.getElementById('instance').value;
    const pr = document.getElementById('price').value;
    const reg = document.getElementById('region').value;

    fetch(`./item.php?instance=${inst}&price=${pr}&region=${reg}`, {method: 'GET'})
        .then(response => response.json())
        .then(displayItems);
}

document.getElementById('import-data').addEventListener('click', insertItems);
document.getElementById('import-data').addEventListener('click', getDate);
document.getElementById('load-data').addEventListener('click', loadItems);
document.getElementById('search').addEventListener('click', searchForItems);

function showButtonsAndSearch() {
    document.getElementById('pc-button').style.display = 'inline-block';
    document.getElementById('load-data').style.display = 'inline-block';
    document.getElementById('form').style.display = 'block';
}

function showElements() {
    document.getElementById('export-form').style.display = "inline-block";

    document.getElementById('up').style.display = "inline-block";
    document.getElementById('down').style.display = "inline-block";

    document.getElementById('input0').style.display = "inline-block";
    document.getElementById('input1').style.display = "inline-block";
    document.getElementById('input7').style.display = "inline-block";
}

function prepareExportData() {
    let result = [];
    
    for(let i = 0; i < 8; i++){
        const elem = document.querySelector(`input[id="ef${i}"]:checked`); 
        if(elem){
            result.push(Number(elem.value));
        }
    }
    
    if(result.length > 0){
        const table = document.getElementById('item-container');
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
            document.getElementById('footer').appendChild(link);
            link.click();
            document.getElementById('footer').removeChild(link);
        }
    }
}

var UtilityFunctions = {
    searchFunction: function (n) {
        var input, filter, table, tr, td, i, txtValue;
    
        input = document.getElementById("input".concat(n));
        filter = input.value.toUpperCase();
    
        table = document.getElementById("item-container");
        tr = table.getElementsByTagName("tr");
      
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[n];
    
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    },

    sortColumn: function (n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    
        table = document.getElementById("item-container");
        switching = true;
    
        // Set the sorting direction to ascending:
        dir = "asc";
        
        while (switching) {
            switching = false;
            rows = table.rows;
    
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[n];
                y = rows[i + 1].getElementsByTagName("td")[n];
    
                if (dir == "asc") {
                    if (n == 2 || n == 3 || n == 5 || n == 6){
                        if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)){
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
    
                } else if (dir == "desc") {
                    if (n == 2 || n == 3 || n == 5 || n == 6){
                        if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)){
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
            }
    
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
}

for(let z = 0; z < 8; ++z){
    document.getElementById(`ef${z}`).addEventListener('dblclick', function() {
        var radio = document.getElementById(`ef${z}`); 
        if(radio.checked){
            radio.checked = false;
        }
    });
}

const btn = document.getElementById("pc-button");
const popup = document.getElementById("popup");
const closebtn = document.getElementById("close");

btn.onclick = function() {
    popup.style.display = "block";
}

closebtn.onclick = function() {
    popup.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == popup) {
        popup.style.display = "none";
    }
}