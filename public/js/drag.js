const taskManager = document.querySelector('main');
let selectedTask;
let selectedTaskList;

const getTaskList = (status) => {
    let taskList;

    switch (status) {
        case "todo":
            taskList = document.querySelector('[data-status="todo"]');
            break;
        case "doing":
            taskList = document.querySelector('[data-status="doing"]');
            break;
        case "done":
            taskList = document.querySelector('[data-status="done"]');
            break;
        default:
            throw new Error("Invalid status");
    }

    const counter = taskList.querySelector("h2 span");
    const search = taskList.querySelector("input");
    const taskHolder = taskList.querySelector("div");

    const getTaskCount = () => {
        return taskHolder.children.length;
    }

    const updateCount = () => {
        counter.textContent = taskHolder.children.length;
    }

    const hideSearch = () => {
        search.style.display = "none";
    }

    const showSearch = () => {
        search.style.display = null;
    }

    const listTasks = () => {
        return Array.from(taskHolder.querySelectorAll(":scope > div"));
    }

    const listTaskNames = () => {
        return Array.from(taskHolder.querySelectorAll(":scope > div")).map((task) => task.querySelector("h1").textContent);
    }

    const hideNthTask = (n) => {
        taskHolder.children[n].style.display = "none";
    }

    const showNthTask = (n) => {
        taskHolder.children[n].style.display = null;
    }

    const setHeight = (height) => {
        taskList.style.height = height;
    }

    const taskLightHeight = () => {
        return taskList.offsetHeight;
    }


    return {
        taskList,
        taskHolder,
        getTaskCount,
        updateCount,
        search,
        hideSearch,
        showSearch,
        listTaskNames,
        hideNthTask,
        showNthTask,
        setHeight,
        taskLightHeight,
        listTasks,
        status
    };
};

const todoTaskList = getTaskList("todo");
const doingTaskList = getTaskList("doing");
const doneTaskList = getTaskList("done");
const taskLists = [todoTaskList, doingTaskList, doneTaskList];

const getTaskListFromStatus = (status) => {
    switch (status) {
        case "todo":
            return todoTaskList;
        case "doing":
            return doingTaskList;
        case "done":
            return doneTaskList;
    }
};

const updateTask = async (taskId, oldStatus, newStatus) => {
    const oldTaskList = getTaskListFromStatus(oldStatus);
    const newTaskList = getTaskListFromStatus(newStatus);

    oldTaskList.updateCount();
    newTaskList.updateCount();

    fetch("/task?id=" + taskId, {
        method: "PUT",
        body: JSON.stringify({ status: newStatus }),
    })
};

taskLists.forEach((taskList) => {
    if (taskList.getTaskCount() === 0) taskList.hideSearch();

    taskList.search.addEventListener("keyup", async (e) => {
        const searchValue = e.target.value.toLowerCase();
        const taskNames = taskList.listTaskNames();

        taskNames.forEach((taskName, i) => {
            if (searchValue === "" || taskName.includes(searchValue)) {
                taskList.showNthTask(i);
                return;
            }

            taskList.hideNthTask(i);
        });
    });

    taskList.taskList.addEventListener("mouseenter", () => {
        selectedTaskList = taskList.taskList;

        if (selectedTask) {
            taskList.setHeight(taskList.taskLightHeight() + selectedTask.offsetHeight + 'px');
            taskList.taskList.classList.add("opacity-60");
        }
    });

    taskList.taskList.addEventListener("mouseleave", () => {
        if (!selectedTask) {
            taskList.setHeight(null);
            return;
        }

        taskList.setHeight(selectedTaskList.offsetHeight - selectedTask.offsetHeight + 'px');
        taskList.taskList.classList.remove("opacity-60");
        selectedTaskList = null;
    });
});

taskLists.forEach((taskList) => {
    taskList.listTasks().forEach((task) => {
        task.onmousedown = (e) => {
            if (e.target.tagName === "A") return;

            e.preventDefault();

            const taskClone = task.cloneNode(true);
            selectedTask = taskClone;

            taskClone.style.top = task.offsetTop + 'px';
            taskClone.style.left = task.offsetLeft + 'px';
            taskClone.classList.add("absolute");
            taskClone.style.width = task.offsetWidth + 'px';
            taskManager.appendChild(taskClone);
            console.log(taskManager);
            task.remove();

            let x = e.clientX;
            let y = e.clientY;

            document.onmouseup = async () => {
                taskClone.remove();

                document.onmouseup = null;
                document.onmousemove = null;

                if (selectedTaskList) {
                    const taskHolder = selectedTaskList.querySelector("div")
                    taskHolder.appendChild(task);

                    selectedTaskList.classList.remove("opacity-60");
                    selectedTaskList.style.height = null;
                    taskHolder.style.height = null;

                    const taskId = selectedTask.getAttribute("id");
                    const newStatus = selectedTaskList.getAttribute("data-status");

                    if (taskList.getTaskCount() === 0)
                        taskList.hideSearch();

                    await updateTask(taskId, taskList.status, newStatus);

                    taskList = getTaskListFromStatus(newStatus);

                    if (taskList.getTaskCount() === 1)
                        taskList.showSearch();
                } else {
                    taskList.taskHolder.appendChild(task);
                    taskList.setHeight(null);
                }

                selectedTask = null;
                selectedTaskList = null;
            };

            document.onmousemove = (e) => {
                e.preventDefault();

                let newX = x - e.clientX;
                let newY = y - e.clientY;
                x = e.clientX;
                y = e.clientY;

                taskClone.style.top = (taskClone.offsetTop - newY) + "px";
                taskClone.style.left = (taskClone.offsetLeft - newX) + "px";
            };
        };
    });
});
