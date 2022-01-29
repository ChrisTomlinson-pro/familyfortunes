<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    @foreach($quizzes as $quiz)
                        <div class="max-w-0 align-content-between">
                            <div>{{ $quiz->name }}</div>
                            <div>
                                <a href="{{ route('begin-broadcast', ['quiz' => $quiz->uuid])  }}">Begin Broadcasting</a>
                            </div>
                            <form action="{{ route('quiz-delete', ['quiz' => $quiz->uuid]) }}" content="enctype-multipart" method="delete">
                                @method("DELETE")
                                <div>
                                    <button type="submit" class="btn btn-sm btn-danger" >Delete</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
