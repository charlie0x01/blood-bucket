<!-- Modal -->
<div id="small-modal" tabindex="-1" class="hidden fixed top-0 left-10 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-medium text-gray-900 ">
                    Chatbox
                </h3>
                <button id="close-chatbox" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="small-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">

                <!-- Chat messages -->
                <div id="chat" class="h-48 overflow-y-auto mb-4">
                    <!-- Sample messages (replace with dynamic content from your backend) -->
                    <div class="mb-2">
                        <span class="font-semibold">Sender Name:</span>
                        <p class="bg-blue-500 text-white rounded-lg p-2 inline-block">Hello!</p>
                    </div>
                    <div class="mb-2 text-right">
                        <span class="font-semibold">You:</span>
                        <p class="bg-green-500 text-white rounded-lg p-2 inline-block">Hi there!</p>
                    </div>
                    <!-- Add more message divs dynamically based on your messages -->
                </div>

                <!-- Message input and send button -->
                <form id="messageForm" action="/chat/send/{recipient}" method="post" class="flex">
                    @csrf
                    <input type="text" id="messageInput" name="content" placeholder="Type your message" class="flex-1 p-2 border rounded" />
                    <button type="submit" class="ml-2 bg-blue-500 text-white p-2 rounded">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>