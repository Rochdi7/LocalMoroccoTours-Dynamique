{{-- resources/views/partials/review-scripts.blade.php --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function hasVoted(reviewId, type) {
            const votes = JSON.parse(localStorage.getItem('reviewVotes') || '{}');
            return votes[reviewId] && votes[reviewId][type];
        }

        function setVoted(reviewId, type) {
            const votes = JSON.parse(localStorage.getItem('reviewVotes') || '{}');
            if (!votes[reviewId]) votes[reviewId] = {};
            votes[reviewId][type] = true;
            localStorage.setItem('reviewVotes', JSON.stringify(votes));
        }

        function hasVotedEither(reviewId) {
            const votes = JSON.parse(localStorage.getItem('reviewVotes') || '{}');
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

        function notify(message, icon = 'info') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        }

        function sendVote(url, btn, countClass, reviewId, type) {
            if (hasVotedEither(reviewId)) {
                notify('You have already voted on this review.', 'info');
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
                        console.error("HTML response instead of JSON:", html);
                        throw new Error("Server error — see console.");
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
                    notify(data.message || 'Vote failed.', 'warning');
                }
            })
            .catch(error => {
                notify(error.message || 'Error voting.', 'error');
                console.error(error);
            });
        }

        document.querySelectorAll('.js-helpful-btn').forEach(btn => {
            const reviewId = btn.getAttribute('data-review-id');
            if (hasVoted(reviewId, 'helpful')) disableOppositeVote(reviewId, 'helpful');

            btn.addEventListener('click', e => {
                e.preventDefault();
                if (btn.classList.contains('disabled')) {
                    notify('You already voted not helpful for this review.', 'info');
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
                    notify('You already voted helpful for this review.', 'info');
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
