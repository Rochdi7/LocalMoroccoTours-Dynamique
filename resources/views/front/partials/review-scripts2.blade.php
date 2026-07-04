<script>
    document.addEventListener('DOMContentLoaded', function () {

        function getVotes() {
            return JSON.parse(localStorage.getItem('reviewVotes') || '{}');
        }

        function hasVoted(reviewId, type) {
            const votes = getVotes();
            return votes[reviewId] && votes[reviewId][type];
        }

        function setVoted(reviewId, type) {
            const votes = getVotes();
            if (!votes[reviewId]) votes[reviewId] = {};
            votes[reviewId][type] = true;
            localStorage.setItem('reviewVotes', JSON.stringify(votes));
        }

        function hasVotedEither(reviewId) {
            const votes = getVotes();
            return votes[reviewId] && (votes[reviewId].helpful || votes[reviewId].notHelpful);
        }

        function disableOppositeVote(reviewId, votedType) {
            const container = document.querySelector(`[data-review-id="${reviewId}"]`);
            if (!container) return;
            if (votedType === 'helpful') {
                const notHelpfulBtn = container.querySelector('.js-not-helpful-btn');
                if (notHelpfulBtn) notHelpfulBtn.classList.add('disabled');
            } else if (votedType === 'notHelpful') {
                const helpfulBtn = container.querySelector('.js-helpful-btn');
                if (helpfulBtn) helpfulBtn.classList.add('disabled');
            }
        }

        function sendVote(url, btn, countClass, reviewId, type) {
            if (hasVotedEither(reviewId)) {
                alert('You have already voted on this review.');
                return;
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(html => {
                        console.error("Unexpected HTML response:", html);
                        throw new Error("Server error — see console for details.");
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.querySelectorAll(`[data-review-id="${reviewId}"] .${countClass}`)
                        .forEach(span => {
                            span.textContent = data[countClass];
                        });
                    setVoted(reviewId, type);
                    disableOppositeVote(reviewId, type);
                } else {
                    alert(data.message || "Vote failed.");
                }
            })
            .catch(error => {
                alert(error.message || 'Error voting.');
                console.error(error);
            });
        }

        document.querySelectorAll('.js-helpful-btn').forEach(btn => {
            const reviewId = btn.getAttribute('data-review-id');
            if (hasVoted(reviewId, 'helpful')) disableOppositeVote(reviewId, 'helpful');

            btn.addEventListener('click', e => {
                e.preventDefault();
                if (btn.classList.contains('disabled')) {
                    alert('You already voted not helpful for this review.');
                    return;
                }
                sendVote(`/review/${reviewId}/helpful`, btn, 'helpful_count', reviewId, 'helpful');
            });
        });

        document.querySelectorAll('.js-not-helpful-btn').forEach(btn => {
            const reviewId = btn.getAttribute('data-review-id');
            if (hasVoted(reviewId, 'notHelpful')) disableOppositeVote(reviewId, 'notHelpful');

            btn.addEventListener('click', e => {
                e.preventDefault();
                if (btn.classList.contains('disabled')) {
                    alert('You already voted helpful for this review.');
                    return;
                }
                sendVote(`/review/${reviewId}/not-helpful`, btn, 'not_helpful_count', reviewId, 'notHelpful');
            });
        });

    });
</script>

<style>
    a.disabled {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
