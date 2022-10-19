<div>
    @if(!empty($broadcastingQuiz))
        <div>
            @if(!empty($activeQuestion))
                <table>
                    <thead>
                        <th>
                            Active Question
                        </th>
                        <th>
                            Submitted Answers
                        </th>
                        <th>
                            Actions
                        </th>
                    </thead>
                    <tbody>

                        <td>
                            {{ $activeQuestion->text }}
                        </td>
                        <td>
                            @foreach($answers as $answer)
                            {{--                            Potentially use the displayed field to check if this answer is displayed or not--}}
                                <div>
                                    {{ $answer->text }}
                                </div>
                                <button>
                                    Display
                                </button>
                                <br>
                            @endforeach
                        </td>
                        <td>
                            <button>
                                Open Question for Answers
                            </button>
                        </td>
                    </tbody>
                </table>
            @endif

            <table>
                <thead>
                     <th>
                        Next Question
                    </th>
                    <th>
                        Actions
                    </th>
                </thead>
                <tbody>
                    <td>
                        {{ $nextQuestion->text }}
                    </td>
                    <td>
                        <button>
                            Move to Next Question
                        </button>
                    </td>
                </tbody>
            </table>
        </div>
    @else
        <div>No content</div>
    @endif
</div>
