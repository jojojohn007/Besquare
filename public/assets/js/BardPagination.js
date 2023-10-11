/* <div id="data-container"></div>
<div id="pagination-container"></div> */
if(document.getElementById('pagination-container')) {
   


// Sample data
const data = [
  'Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5',
  'Item 6', 'Item 7', 'Item 8', 'Item 9', 'Item 10',
  'Item 11', 'Item 12', 'Item 13', 'Item 14', 'Item 15'
];

const itemsPerPage = 5; // Number of items to display per page
let currentPage = 1; // Current page

function displayData(page) {
  const startIndex = (page - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const dataSlice = data.slice(startIndex, endIndex);

  const dataContainer = document.getElementById('data-container');
  dataContainer.innerHTML = '';

  dataSlice.forEach(item => {
    const itemElement = document.createElement('div');
    itemElement.textContent = item;
    dataContainer.appendChild(itemElement);
  });
}

function displayPagination() {
  const totalPages = Math.ceil(data.length / itemsPerPage);
  const paginationContainer = document.getElementById('pagination-container');
  paginationContainer.innerHTML = '';

  for (let i = 1; i <= totalPages; i++) {
    const pageLink = document.createElement('a');
    pageLink.href = '#';
    pageLink.textContent = i;
    pageLink.classList.add('pagination-link');
    
    // Add an event listener to each page link
    pageLink.addEventListener('click', function() {
      currentPage = i;
      displayData(currentPage);
      highlightCurrentPage();
    });
    
    paginationContainer.appendChild(pageLink);
  }

  highlightCurrentPage();
}

function highlightCurrentPage() {
  const pageLinks = document.getElementsByClassName('pagination-link');
  
  // Remove the 'active' class from all page links
  Array.from(pageLinks).forEach(link => {
    link.classList.remove('active');
  });
  
  // Add the 'active' class to the current page link
  pageLinks[currentPage - 1].classList.add('active');
}

// Initial display
displayData(currentPage);
displayPagination();

};