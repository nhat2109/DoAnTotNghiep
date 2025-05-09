<div class="review-card rating-{rating}">
  <input type="hidden" name="rating_number" value="{rating}" />
    <div class="review-header">
      <span><strong>{name}</strong></span>
      <span class="review-stars">{rating_fomat}</span>
    </div>
    <p>{comment}</p>
    <div class="review-actions">
      <span class="text-gray-500">{created_at}</span>
    </div>
  </div>