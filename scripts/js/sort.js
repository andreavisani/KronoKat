
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

// WHENEVER THE TASK LIST IS EMPTY, A MESSAGE IS DISPLAYED INSTEAD OF THE TASK LIST
document.addEventListener('DOMContentLoaded', function() {
    var taskItems = document.querySelectorAll('.task-item');
        
    // Convert NodeList to array for easier manipulation
    var taskArray = Array.from(taskItems);
    
    // Reverse the order of the array
    taskArray.reverse();
    
    // Clear the existing list
    var taskList = document.getElementById('task-list');

    if(taskArray.length === 0){
    taskList.innerHTML = '<p id="default-message">You\'re on track</p>';
    }

});
