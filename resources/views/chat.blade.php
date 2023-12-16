<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ChatBox') }}
        </h2>
        <p class="mb-2">Donor and Recipeint can have chat here.</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded shadow-md w-full">
                <div class="w-full shadow">
                    @if($receiver_name == 'Blood Bucket')
                    <h1 class="p-2 text-xl font-semibold text-center">
                        {{ 'Admin: '.$receiver_name }}
                    </h1>
                    @else 
                    <h1 class="p-2 text-xl font-semibold text-center">
                        {{ $receiver_name }}
                    </h1>
                    @endif
                </div>
                <!-- Chat messages -->
                <div class="flex min-h-[500px] flex-col space-y-2 h-64 overflow-y-auto p-4">
                    @foreach($messages as $message)

                    @if($message->sender_id == auth()->user()->id)
                    <!-- Sender message -->
                    <div class="flex flex-col items-end">
                        <div class="bg-blue-500 text-white p-2 rounded">
                            {{ $message->content }}
                        </div>
                        <span class="text-xs text-gray-500 ml-2">
                        {{ \Carbon\Carbon::parse($message->created_at)->format('h:i A') }}
                        </span>
                    </div>

                    <!-- Receiver message -->
                    @else
                    <div class="flex flex-col items-start">
                        <div class="bg-gray-300 p-2 rounded">
                            {{ $message->content }}
                        </div>
                        <span class="text-xs text-gray-500 ml-2">
                            {{ \Carbon\Carbon::parse($message->created_at)->format('h:i A') }}
                        </span>
                    </div>
                    @endif
                    @endforeach

                    <!-- Add more messages as needed -->
                </div>

                <!-- Message input -->
                <form 
                action="{{ route('send.message', ['bid' => $bid, 'rid' => $receiver_id ]) }}" 
                method="POST" class="">
                    @csrf
                    @method('POST')
                    <div class="flex mt-4 p-4">
                        <input name="content" type="text" placeholder="Type your message" class="flex-1 border rounded-l p-2 focus:outline-none">
                        <button class="bg-blue-500 text-white rounded-r p-2">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>