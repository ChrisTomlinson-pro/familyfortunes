<x-app-layout>
    @push('scripts')
        <script>
            let selectedQuiz = '';
            let questionList = '';

            function selectQuiz(quizUuid) {
                document.getElementById('begin-broadcast-button').disabled = false;
                document.getElementById('delete-quiz-button').disabled = false;
                selectedQuiz = quizUuid;
                fetchQuestionList(quizUuid);
            }

            function fetchQuestionList(quizUuid) {
                const url = '{{ url('/') . '/display/all-questions-for-quiz/' }}' + quizUuid;
                axios.get(url).then((response) => {
                    if (response.status === 200) {
                        generateQuestionList(response.data)
                    } else {
                        console.log(response);
                    }
                });
            }

            function generateQuestionList(questions) {
                console.log(questions);
                let wrapper = document.getElementById('question-list-wrapper');
                {{--wrapper.appendChild(`@include('components.admin-question-list-component', ['questions' => {!! $questions !!}])`);--}}

            }

            function broadcastBtnClick() {
                const broadcastUrl = '{{ url('/') . '/broadcasting/quiz/begin-broadcast/' }}' + selectedQuiz;
                axios.get(broadcastUrl).then((response) => {
                    if (response.status === 201) {
                        window.location.reload();
                    }
                });
            }

            function endBroadcastBtnClick() {
                const endBroadcastUrl = '{{url('/') . '/broadcasting/quiz/end-broadcast/' . $activeQuiz }}'
                console.log(endBroadcastUrl);
                axios.get(endBroadcastUrl).then((response) => {
                    if (response.status === 201) {
                        window.location.reload();
                    }
                })
            }
        </script>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

{{--Quiz Select--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:question-list />
                </div>
            </div>
        </div>
    </div>

{{--Quiz Admin View--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:quiz-admin-view />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
