<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Upload Your CSV File Here') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                    <div class="text-sm text-green-600">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="text-sm text-red-600">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('products.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">
                                <input type="file" name="csv" class="block w-full text-sm text-gray-500 p-2 rounded-full border-0 text-sm font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100" multiple />
                            </label>
                            @error('csv')
                            <div class="text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Add "justify-end" class to align the button to the right -->
                        <div class="flex justify-end">
                            <x-primary-button class="ml-3">
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="table-container" class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Filename</th>
                    <th>Created At</th>
                    <th>Upload Status</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Rows will be dynamically added here -->
            </tbody>
        </table>
    </div>


</x-app-layout>





<!-- <script type="module">
    const tableBody = document.getElementById('table-body');
    const dataMap = new Map();

    // Initial data retrieval
    fetch('/get-upload-history') // Replace with the actual route
        .then(response => response.json())
        .then(data => {
            data.forEach(entry => {
                appendRow(entry.filename, entry.created_at, entry.upload_status);
                dataMap.set(entry.id, entry);
            });
        })
        .catch(error => console.error(error));

    // Listen for a WebSocket event on the "public-upload-history" channel
    Echo.channel('public-upload-history')
        .listen('.UploadHistoryEvent', (data) => {
            updateView(data.upload_history);
        });

    function updateView(data) {
        const id = data.id;
        const filename = data.filename;
        const created_at = data.created_at;
        const upload_status = data.upload_status;

        if (!dataMap.has(id)) {
            appendRow(filename, created_at, upload_status);
            dataMap.set(id, { filename, created_at, upload_status });
        } else {
            updateRow(id, filename, upload_status);
            dataMap.set(id, { filename, created_at, upload_status });
        }
    }

    function appendRow(filename, created_at, upload_status) {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${filename}</td>
            <td>${created_at}</td>
            <td>${upload_status}</td>
        `;
        tableBody.appendChild(newRow);
    }

    function updateRow(id, filename, upload_status) {
        const rows = tableBody.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length === 3 && cells[0].textContent === filename) {
                // Update the row if the filename matches
                cells[2].textContent = upload_status;
                break;
            }
        }
    }
</script> -->












<script type="module">
    const tableBody = document.getElementById('table-body');
    const dataMap = new Map();

    // Initial data retrieval
    fetch('/get-upload-history') // Replace with the actual route
        .then(response => response.json())
        .then(data => {
            data.forEach(entry => {
                appendRow(entry.filename, entry.created_at, entry.upload_status);
                dataMap.set(entry.id, entry);
            });
        })
        .catch(error => console.error(error));

    // Listen for a WebSocket event on the "public-upload-history" channel
    Echo.channel('public-upload-history')
        .listen('.UploadHistoryEvent', (data) => {
            updateView(data.upload_history);
        });

    function updateView(data) {
        const id = data.id;
        const filename = data.filename;
        const created_at = data.created_at;
        const upload_status = data.upload_status;

        if (!dataMap.has(id)) {
            appendRowToTop(filename, created_at, upload_status);
            dataMap.set(id, { filename, created_at, upload_status });
        } else {
            updateRow(id, filename, upload_status);
            dataMap.set(id, { filename, created_at, upload_status });
        }
    }

    function appendRowToTop(filename, created_at, upload_status) {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${filename}</td>
            <td>${created_at}</td>
            <td>${upload_status}</td>
        `;
        // Insert the new row at the top of the table (before the first child)
        tableBody.insertBefore(newRow, tableBody.firstChild);
    }

    function appendRow(filename, created_at, upload_status) {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${filename}</td>
            <td>${created_at}</td>
            <td>${upload_status}</td>
        `;
        tableBody.appendChild(newRow);
    }

    function updateRow(id, filename, upload_status) {
        const rows = tableBody.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            if (cells.length === 3 && cells[0].textContent === filename) {
                // Update the row if the filename matches
                cells[2].textContent = upload_status;
                break;
            }
        }
    }
</script>
