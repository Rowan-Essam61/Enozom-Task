//DOM queries
const DOMStrings = {
    table: document.querySelector('table'),
    link: document.querySelector('.view'),
    parentDivBtn: document.querySelector('.btnHolder')
};

  //array
var response;
var populations=Array("","","","","","","");

var xHTTP = new XMLHttpRequest();
    xHTTP.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response= JSON.parse(xHTTP.responseText) ;
            populations=response.data;
            renderPopulation(populations);
            };
        };
    xHTTP.open("GET", "http://localhost/enozom-task/api/readAll.php", true);
    xHTTP.send();

  //remove the link, buttons and list enteries
  const clearResults = () => {
    DOMStrings.link.innerHTML = '';
    DOMStrings.table.innerHTML = '';
    DOMStrings.parentDivBtn.innerHTML = '';
  };
  
  //add the fruits to the UI
  const renderPopulation = (populations) =>{
    const list =`<tr><td>${populations.id}</td>
    <td>${populations.country_name}</td>
    <td>${populations.city_name}</td>
    <td>${populations.year}</td>
    <td>${populations.sex}</td>
    <td>${populations.value}</td>
    <td>${populations.reliabilty}</td></tr>`; 
    DOMStrings.table.insertAdjacentHTML('beforeend', list);
  };
  //add the buttons to the UI
  const renderButton = (page, type) => 
   `<button class="pageBtn ${type}" type="button" data-goto="${type === 'prev'? page - 1 : page + 1}"><i class="fas fa-caret-${type === 'prev'? 'left': 'right'}"></i> Page ${type === 'prev'? page -1 : page + 1}</button>`;
  
  //set the buttons as per the data and pages
  const calcPage = (page, numFruits, resPerPage) => {
    const totalPages = Math.ceil(numFruits/resPerPage);
    let final;
    if(page === 1 && totalPages > 1){
       final = renderButton(page, 'next');
       }
    else if(page < totalPages){
       final = `${renderButton(page, 'prev')} ${renderButton(page, 'next')}`;
      }
    else if(page === totalPages && totalPages > 1){
      final = renderButton(page, 'prev');   
     }
     
    DOMStrings.parentDivBtn.insertAdjacentHTML('afterbegin', final);
  };
  
  //set the page, result per page, loop and pass each fruit
  //page and resPerPage are default parameters
  const getPage = (populations, page = 1, resPerPage = 50) => {
    const first = (page - 1) * resPerPage;
    const end = page * resPerPage;
    populations.slice(first, end).forEach(renderPopulation);
    calcPage(page, populations.length, resPerPage);
  };
  
  //Event delegation using the Div to add listener to the button inside
  DOMStrings.parentDivBtn.addEventListener('click', (e) =>{
      const button = e.target.closest('.pageBtn');
      if(button){
        const goto = parseInt(button.dataset.goto, 10);
        clearResults();
        getPage(populations, goto);
      }
  });
  
  //click the link
  DOMStrings.link.addEventListener('click', () => {
    clearResults();
    getPage(populations);
  });
  
  
  
  
  