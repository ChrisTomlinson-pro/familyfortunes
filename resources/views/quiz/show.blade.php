<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1>{{ $quiz->name  }}</h1>

                    @foreach( $questionsAndAnswers as $index => $questionAndAnswer)
                        <div class="flex">
                                <form action="{{ route('question-update', ["question" => $questionAndAnswer->uuid]) }}" method="post" enctype="multipart/form-data">
                                @method('POST')
                                @csrf
                                    <div class="flex">
                                        <h4>{{ $index + 1 }} </h4>
                                        <input class="form-input mt-1 block w-full" name="text" placeholder="{{ $questionAndAnswer->text }}" required/>
                                    </div>
                                <div class="flex">

                                    <button
                                        class="
                                        bg-purple-500
                                        text-white
                                        active:bg-purple-600
                                        font-bold
                                        uppercase
                                        text-xs
                                        px-4
                                        py-2
                                        rounded
                                        shadow
                                        hover:shadow-md
                                        outline-none
                                        focus:outline-none
                                        mr-1
                                        mb-1
                                        ease-linear
                                        transition-all
                                        duration-150
                                        "
                                        type="submit"
                                    >
                                        Update
                                    </button>
                                </form>
                                <form action="{{ route('question-destroy', ["question" => $questionAndAnswer->uuid]) }}" method="post" enctype="multipart/form-data">
                                @method('POST')
                                @csrf
                                    <button
                                        class="
                                        bg-purple-500
                                        text-white
                                        active:bg-purple-600
                                        font-bold
                                        uppercase
                                        text-xs
                                        px-4
                                        py-2
                                        rounded
                                        shadow
                                        hover:shadow-md
                                        outline-none
                                        focus:outline-none
                                        mr-1
                                        mb-1
                                        ease-linear
                                        transition-all
                                        duration-150
                                        "
                                        type="submit"
                                    >
                                        Delete
                                    </button>
                                </form>
                                </div>
                                @foreach($questionAndAnswer->answers as $answerIndex => $answer)
                                    <form action="{{ route('answer-destroy', ["answer" => $questionAndAnswer->uuid, "quiz" => $quiz->uuid]) }}" method="post" enctype="multipart/form-data">
                                    @method('POST')
                                    @csrf
                                        <div class="flex">
                                            <div>{{ $answerIndex + 1 . ". " . $answer->text }}</div>
                                            <button
                                                class="
                                                bg-purple-500
                                                text-white
                                                active:bg-purple-600
                                                font-bold
                                                uppercase
                                                text-xs
                                                px-4
                                                py-2
                                                rounded
                                                shadow
                                                hover:shadow-md
                                                outline-none
                                                focus:outline-none
                                                mr-1
                                                mb-1
                                                ease-linear
                                                transition-all
                                                duration-150
                                            "
                                                type="submit"
                                            >
                                                Delete
                                            </button>

                                        </div>
                                @endforeach
                        </div>

                    @endforeach

                    <form action="{{ route('question-store', ["quiz" => $quiz->uuid]) }}" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="p-4 shadow-md rounded-md text-left" style="max-width: 400px">
                            <label class="block">
                                <span class="text-gray-700">Add a question</span>
                                <input class="form-input mt-1 block w-full" name="text" placeholder="Example Question" required/>
                            </label>
                            <br/>

                            <button
                                class="
                                    bg-purple-500
                                    text-white
                                    active:bg-purple-600
                                    font-bold
                                    uppercase
                                    text-xs
                                    px-4
                                    py-2
                                    rounded
                                    shadow
                                    hover:shadow-md
                                    outline-none
                                    focus:outline-none
                                    mr-1
                                    mb-1
                                    ease-linear
                                    transition-all
                                    duration-150
                                    "
                                type="submit"
                            >
                                Save
                            </button>

                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
