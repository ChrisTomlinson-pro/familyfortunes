<div>
    {{-- The whole world belongs to you. --}}
    @if($broadcastingQuiz)

        <div class="pt-2 pb-2 flex">
            <h2 class="mr-1">{{ $broadcastingQuiz->name }} broadcasting...</h2>
            <button
                id="end-broadcast-button"
                class="mr-1 relative text-xs w-fit h-fit bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded mr-1"
                wire:click="endBroadcast('{{ $broadcastingQuiz->uuid }}')"
            >
                End Broadcast
            </button>
        </div>

    @else
        <select wire:model="activeQuiz">
        <option value="" selected>Select Quiz</option>
        @foreach($quizzes as $quiz)
            <option value="{{ $quiz->uuid }}">{{ $quiz->name }}</option>
        @endforeach
    </select>

    @if (!empty($activeQuiz))
        <div class="mt-2">
            @foreach($questions as $question)
            <div class="flex justify-between mb-0.5">
                <p>{{ $question->text }}</p>
                <div class="flex">
                    <button
                        id="delete-question-{{ $question->uuid }}"
                        class="mr-1 relative text-xs w-fit h-fit bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded mr-1"
                        wire:click="deleteQuestion('{{ $question->uuid }}')"
                    >
                        Delete question
                    </button>

                    <button
                        id="edit-question-{{ $question->uuid }}"
                        class="mr-1 relative text-xs w-fit h-fit bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded mr-1"
                        wire:click="editQuestion('{{ $question->uuid }}')"
                    >
                            Edit question
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-2 flex">
            @if($questions->isNotEmpty())
            <button
                id="begin-broadcast-button"
                class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded mr-1"
                wire:click="startBroadcast('{{ $activeQuiz }}')"
            >
                Begin Broadcasting
            </button>
            @endif
            <button
                id="delete-quiz-button"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                wire:click="deleteQuiz('{{ $activeQuiz }}')"
            >
                Delete
            </button>
        </div>
    @endif
    @endif
</div>
