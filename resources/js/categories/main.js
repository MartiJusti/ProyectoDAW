async function fetchAllCategories(apiUrl, taskCategories, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/categories`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!response.ok) {
            throw new Error('Error al obtener las categorías.');
        }

        const data = await response.json();
        const categorySelect = document.getElementById("category-select");
        categorySelect.innerHTML = '<option value="">Seleccione una categoría</option>';

        const filteredCategories = data.filter(category => !taskCategories.includes(category.id));

        filteredCategories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });
    } catch (error) {
        /* console.error(error.message); */
    }
}

async function fetchTaskCategories(apiUrl, taskId, categories, accessToken) {
    try {
        const response = await fetch(`${apiUrl}/tasks/${taskId}/categories`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        });

        if (!response.ok) {
            throw new Error('Error al obtener las categorías de la tarea.');
        }

        const data = await response.json();
        const categoryList = document.getElementById("category-list");
        categoryList.innerHTML = '';
        categories.length = 0;

        if (data.length === 0) {
            categoryList.innerHTML = '<li>No hay categorías asignadas a esta tarea.</li>';
        } else {
            data.forEach(category => {
                const listItem = document.createElement('li');
                listItem.textContent = category.name;
                listItem.className = 'text-gray-700';
                categoryList.appendChild(listItem);

                categories.push(category.id);
            });
        }
    } catch (error) {
        /* console.error(error.message); */
    }
}

async function assignCategoryToTask(apiUrl, taskId, categories, accessToken) {
    const categoryId = document.getElementById('category-select').value;

    if (!categoryId) {
        showToast("Por favor, selecciona una categoría", "linear-gradient(to right, #DB0202, #750000)");
        return;
    }

    try {
        const response = await fetch(`${apiUrl}/tasks/${taskId}/assign-category`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${accessToken}`

            },
            body: JSON.stringify({
                category_id: categoryId
            }),
        });

        if (!response.ok) {
            const data = await response.json();
            throw new Error(data.error || 'Error al asignar la categoría.');
        }

        const data = await response.json();
        showToast("Categoría asignada correctamente", "linear-gradient(to right, #00b09b, #96c93d)");
        document.getElementById('category-select').value = '';

        await fetchTaskCategories(apiUrl, taskId, categories);
        await fetchAllCategories(apiUrl, categories);

    } catch (error) {
        /* console.error(error.message); */
    }
}

function showToast(message, background) {
    Toastify({
        text: message,
        duration: 2000,
        gravity: "top",
        position: "right",
        style: {
            background: background,
        }
    }).showToast();
}

window.initializeCategoryFunctions = function (apiUrl, taskId, categories, accessToken) {
    fetchTaskCategories(apiUrl, taskId, categories, accessToken);
    fetchAllCategories(apiUrl, categories, accessToken);

    const assignCategoryButton = document.getElementById('assign-category');
    assignCategoryButton.addEventListener('click', function () {
        assignCategoryToTask(apiUrl, taskId, categorie, accessToken);
    });
};
