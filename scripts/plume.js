//when document is ready
//  PLUME = find element with [plume]
//  
//  if no elements have [plume], return
//
//  generate menu elements (including listeners)
//  check if <plume-menu /> exists
//  if it does:
//      add menu elements as child of <plume-menu />
//  else:
//      add menu elements as child of <body>
//
//  


// <div class="list-options-pos">
// <div id="list-options">
//     <div class="list-option" id="add">
//         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
//     </div>
//     <div class="list-option" id="cancel" disabled>
//         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/></svg>
//     </div>
//     <div class="list-option" id="shiftup" disabled>
//         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>
//     </div>
//     <div class="list-option" id="shiftdown" disabled>
//         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>
//     </div>
//     <div class="list-option" id="changepos" disabled>
//         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M7 11.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/></svg>
//     </div>
//     <div class="list-option" id="remove" disabled>
//         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
//     </div>
// </div>
// </div>

function defaultAdd(menu) {
    menu.toggleSubmenu('selection');
}

function defaultCancel(menu) {
    menu.toggleSubmenu('waiting');
}

function defaultShiftUp(menu) {

}

function defaultShiftDown(menu) {

}

function defaultChangePos(menu) {

}

function defaultEdit(menu) {

}

function defaultRemove(menu) {

}

class List {
    newItem =   <template>
                    <li>
                        <input type="text"></input>
                        <div plume-autocomplete></div>
                    </li>
                </template>;
    item = <template><li></li></template>;

    constructor(list) {
        this.elem = list;
        this.items = [];

        for (let i = 0; i < list.children.length; i++) {
            list.children[i].setAttribute('plume-index', i);
            this.items.push(list.children[i]);
        }
    }

    addItem() {
        this.elem.appendChild()
    }
}

class Menu {
    constructor(menu) {
        this.elem = menu;
        this.options = [];

        menu.addEventListener('click', e => {
            let elem = e.target;

            while (!elem.classList.contains('plume-option')) {
                elem = elem.parentNode;
                if (elem == menu) return;
            }

            const id = elem.id.replace('plume-', '');
            this.runAction(id);
        })
    }

    addOption(id) {
        if (this.options.find(option => option.id == id)) throw new Error("Option " + id + " already exists");
        const button = document.createElement("button");
        button.id = "plume-" + id;
        button.classList.add('plume-option');
        this.elem.appendChild(button);

        const newOption = {id, button};

        if (id == 'add') {
            newOption.submenu = 'waiting';
            newOption.action = defaultAdd;
            newOption.button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>';
        }

        if (id == 'cancel') {
            newOption.submenu = 'adding';
            newOption.action = defaultCancel;
            newOption.button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/></svg>';
        }

        if (id == 'shiftup') {
            newOption.submenu = 'selection';
            newOption.action = defaultShiftUp;
            newOption.button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-circle" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg>';
        }

        if (id == 'shiftdown') {
            newOption.submenu = 'selection';
            newOption.action = defaultShiftDown;
            newOption.button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/></svg>';
        }

        if (id == 'changepos') {
            newOption.submenu = 'selection';
            newOption.action = defaultChangePos;
            newOption.button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M7 11.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/></svg>';
        }

        if (id == 'edit') {
            newOption.submenu = 'selection';
            newOption.action = defaultEdit;
            newOption.button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16"><path d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/></svg>'
        }

        if (id == 'remove') {
            newOption.submenu = 'selection';
            newOption.action = defaultRemove;
            newOption.button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>';
        }

        this.options.push(newOption);
    }

    getOption(id) {
        const option = this.options.find(option => option.id == id);
        if (!option) throw new Error("Option " + id + " does not exist.");
        return option;
    }

    setAction(id, action) {
        this.getOption(id).action = action;
    }

    runAction(id) {
        this.getOption(id).action(this);
    }

    setHTML(id, HTML) {
        this.getOption(id).button.innerHTML = HTML;
    }

    setSubmenu(id, submenu) {
        this.getOption(id).submenu = submenu;
    }

    toggleSubmenu(submenu) {
        this.options.forEach(option => {
            if (option.submenu == submenu) {
                option.button.style.display = 'block';
            } else {
                option.button.style.display = 'none';
            }
        })
    }
}

/**
 * Generate a set of list options for a given element on this page. (use period)
 *
 * Bind to an element with attribute 'plume'. User may add children to this element
 * and highlight elements to either reorder or delete them depending on the options
 * provided to this function. To perform these actions, a menu is injected either as
 * a directed child of <body> or in the location designated by an element with the
 * 'plume-menu' attribute set. 
 *
 * @param {Object} [params={actions: ['add', 'shift', 'changepos', 'remove']}]     Params for this function.
 * @param {string[]}   [params.actions] Designate what actions should be available for
 * the user in the injected menu. Possible actions are 'add', 'shift',
 * 'changepos' and 'delete'.
 */
function plume(params=['add', 'cancel', 'shiftup', 'shiftdown', 'changepos', 'edit', 'remove']) {
    // let creatingItem = false;
    // let editing = false;
    // let editingElem;

    document.addEventListener('DOMContentLoaded', (event) => {
        const listElem = document.querySelector('[plume]');
        const menuElem = document.querySelector('[plume-menu]');

        if (!plume) {
            console.warn('Unable to find <plume> element on this page. Exiting.');
            return;
        }

        if (!menuElem) {
            menuElem = document.createElement('div');
            menuElem.setAttribute('plume-menu', '');
        }

        const list = new List(listElem);
        const menu = new Menu(menuElem);

        params.forEach(param => menu.addOption(param));

        menu.toggleSubmenu('waiting');

        // const listOptions = document.getElementById("list-options");
        // const listItems = document.getElementById("list-items");

        // const addOptElem = document.getElementById("add");
        // const cancelOptElem = document.getElementById("cancel");
        // const shiftupOptElem = document.getElementById("shiftup");
        // const shiftdownOptElem = document.getElementById("shiftdown");
        // const changeposOptElem = document.getElementById("changepos");
        // const removeOptElem = document.getElementById("remove");


        // const newItemElem = document.createElement("li");
        // const newItemInputContainer = document.createElement("div");
        // const newItemTextEntry = document.createElement("input");
        // const newItemShadowText = document.createElement("div");
        
        // function openEditingMenu() {
        //     addOptElem.setAttribute("disabled", "");
        //     cancelOptElem.setAttribute("disabled", "");
        //     shiftupOptElem.removeAttribute("disabled");
        //     shiftdownOptElem.removeAttribute("disabled");
        //     changeposOptElem.removeAttribute("disabled");
        //     removeOptElem.removeAttribute("disabled");
        // }

        // function closeEditingMenu() {
        //     addOptElem.removeAttribute("disabled");
        //     shiftupOptElem.setAttribute("disabled", "");
        //     shiftdownOptElem.setAttribute("disabled", "");
        //     changeposOptElem.setAttribute("disabled", "");
        //     removeOptElem.setAttribute("disabled", "");
        // }

        // listItems.addEventListener("click", e => {
        //     let listItem = e.target;
        //     while (!listItem.classList.contains("list-name")) {
        //         if (!listItem || listItem.id == "list-items") return;
        //         listItem = listItem.parentNode;
        //     }
            
        //     if (listItem) {
        //         if (!listItem.classList.contains("editable")) return;
        //         const selected = listItem.classList.contains("selected");
        //         for (let i = 0; i < listItems.children.length; i++) {
        //             listItems.children[i].classList.remove("selected");
        //         }

        //         if (selected) {
        //             editing = false;
        //             closeEditingMenu();
        //             listItem.classList.remove("selected");
        //         } else {
        //             if (creatingItem) {
        //                 creatingItem = false;
        //                 listItemsElem.removeChild(newItemElem);
        //             }
        //             if (!editing) {
        //                 editing = true;
        //                 openEditingMenu();
        //             }
        //             listItem.classList.add("selected");
        //             editingElem = listItem;
        //         }
        //     }
        // });

        // newItemElem.className = "list-name";
        // newItemInputContainer.className = "input-container";
        // newItemTextEntry.id = "new-item-input";
        // newItemShadowText.id = "shadow-text";

        // newItemTextEntry.setAttribute("type", "text");
        // newItemElem.appendChild(newItemInputContainer);
        // newItemInputContainer.appendChild(newItemTextEntry);
        // newItemInputContainer.appendChild(newItemShadowText);

        // const listItemsElem = document.getElementById("list-items");
        // listOptions.addEventListener("click", (event) => {
        //     currElem = event.target;
        //     while (!currElem.classList.contains("list-option")) {
        //         if (!currElem || currElem.id == "list-options") return;
        //         currElem = currElem.parentNode;
        //     }

        //     if (currElem.id === "add") {
        //         creatingItem = true;
        //         currElem.setAttribute("disabled", "");
        //         cancelOptElem.removeAttribute("disabled");
        //         listItemsElem.appendChild(newItemElem);
        //         newItemTextEntry.focus();
        //     }

        //     if (currElem.id === "cancel") {
        //         creatingItem = false;
        //         currElem.setAttribute("disabled", "");
        //         addOptElem.removeAttribute("disabled");
        //         listItemsElem.removeChild(newItemElem);
        //     }
            
        //     if (currElem.id === "shiftup") {
        //         if (editingElem.previousSibling) listItems.insertBefore(editingElem, editingElem.previousSibling);
        //     }

        //     if (currElem.id === "shiftdown") {
        //         if (editingElem.nextSibling) listItems.insertBefore(editingElem.nextSibling, editingElem);
        //     }

        //     if (currElem.id === "changepos") {
                
        //     }

        //     if (currElem.id === "remove") {
                
        //     }
        // });
    });
}