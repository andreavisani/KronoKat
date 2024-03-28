
var originalOrder = true; // Flag to track the original order
    
function reverseSort() {
    // Get all task items
    var taskItems = document.querySelectorAll('.task-item');
    
    // Convert NodeList to array for easier manipulation
    var taskArray = Array.from(taskItems);
    
    // Reverse the order of the array
    taskArray.reverse();
    
    // Clear the existing list
    var taskList = document.getElementById('task-list');
    taskList.innerHTML = '';
    
    // Append the sorted items to the list
    taskArray.forEach(function(item) {
        taskList.appendChild(item);
    });
}


