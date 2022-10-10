<?php

namespace App\Services\MapQuestions;

use App\Exceptions\UsedInOtherTableException;
use App\Models\MapAnswer;
use App\Models\MapQuestion;
use Illuminate\Support\Collection;
use Throwable;
use DB;

class MapQuestionService
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return MapQuestion::with('mapAnswers')->orderBy('id')->get();
    }

    /**
     * @param  array  $data
     * @return MapQuestion
     * @throws Throwable
     */
    public function store(array $data): MapQuestion
    {
        return DB::transaction(function () use ($data) {
            $mapQuestion = MapQuestion::create(['question' => $data['question']]);

            $mapAnswers = [];
            $now = now()->toDateTimeString();

            foreach ($data['answers_and_recommendations'] as $datum) {
                $mapAnswers[] = [
                    'answer' => $datum['answer'],
                    'recommendations' => $datum['recommendations'],
                    'map_question_id' => $mapQuestion->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }

            if (!empty($mapAnswers)) {
                MapAnswer::insert($mapAnswers);
            }

            return $mapQuestion;
        });
    }

    /**
     * @param  int  $mapQuestionId
     * @return MapQuestion
     */
    public function getMapQuestionById(int $mapQuestionId): MapQuestion
    {
        return MapQuestion::findOrFail($mapQuestionId);
    }

    /**
     * @param  int  $mapQuestionId
     * @param  array  $data
     * @return MapQuestion
     * @throws Throwable
     */
    public function update(int $mapQuestionId, array $data): MapQuestion
    {
        $mapQuestion = $this->getMapQuestionById($mapQuestionId);

        $mapAnswers = [];
        $newIds = [];
        foreach ($data['answers_and_recommendations'] as $datum) {
            $mapAnswers[] = [
                'id' => $datum['id'] ?? null,
                'answer' => $datum['answer'] ?? null,
                'recommendations' => $datum['recommendations'] ?? null,
                'map_question_id' => $mapQuestion->id
            ];

            if (!empty($datum['id'])) {
                $newIds[] = $datum['id'];
            }
        }

        $ids = $mapQuestion->mapAnswers->pluck('id')->toArray();
        $deleteIds = [];
        foreach ($ids as $id) {
            if (!in_array($id, $newIds, true)) {
                $deleteIds[] = $id;
            }
        }

        return DB::transaction(function () use ($data, $deleteIds, $mapAnswers, $mapQuestion) {
            $mapQuestion->update(['question' => $data['question']]);
            $mapQuestion->mapAnswers()->whereIn('id', $deleteIds)->delete();
            $mapQuestion->mapAnswers()->upsert($mapAnswers, ['id'], ['answer', 'recommendations', 'map_question_id']);

            $mapQuestion->refresh();

            return $mapQuestion;
        });
    }

    /**
     * @param  int  $mapQuestionId
     * @throws UsedInOtherTableException
     */
    public function delete(int $mapQuestionId): void
    {
        try {
            MapQuestion::where('id', $mapQuestionId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Вопрос нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }
}
