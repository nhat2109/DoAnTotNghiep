<div class="li_product li_product_{user_id}" user="{user_id}">
    <div class="thumbnail">
        <img src="{avatar}" alt="{name}" onerror="this.src='/images/user.png';">
    </div>
    <div class="info">
        <div class="name">{name}</div>
        <div style="width: 100%;">
            <div>username: <strong>{username}</strong></div>
            <div>Email: <strong>{email}</strong></div>
        </div>
    </div>
    <div class="action">
        <button user="{user_id}" username="{username}">Thêm</button>
    </div>
</div>