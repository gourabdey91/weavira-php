@if (! post_password_required())
  <section id="comments" class="comments comments-toggle">
    <button
      class="comments-toggle-button"
      type="button"
      aria-expanded="false"
      aria-controls="comments-panel"
      data-comments-toggle
    >
      <span class="comments-toggle-heading">
        <span class="comments-label-wrap">
          <span class="comments-label">Comments</span>
          <span class="comments-count">{{ get_comments_number() }}</span>
        </span>
      </span>

      <span class="comments-toggle-chevron" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
          <path d="M5 12L10 7L15 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
    </button>

    <div id="comments-panel" class="comments-toggle-panel" hidden>
      @if (have_comments())
        <h2 class="comments-title">
          {!! sprintf(
            _nx(
              '%1$s response to &ldquo;%2$s&rdquo;',
              '%1$s responses to &ldquo;%2$s&rdquo;',
              get_comments_number(),
              'comments title',
              'sage'
            ),
            get_comments_number() === 1
              ? _x('One', 'comments title', 'sage')
              : number_format_i18n(get_comments_number()),
            '<span>' . get_the_title() . '</span>'
          ) !!}
        </h2>

        <ol class="comment-list">
          {!! wp_list_comments(['style' => 'ol', 'short_ping' => true]) !!}
        </ol>

        @if (get_comment_pages_count() > 1 && get_option('page_comments'))
          <nav class="comments-nav">
            <ul class="pager">
              @if (get_previous_comments_link())
                <li class="previous">
                  {!! get_previous_comments_link(__('&larr; Older comments', 'sage')) !!}
                </li>
              @endif

              @if (get_next_comments_link())
                <li class="next">
                  {!! get_next_comments_link(__('Newer comments &rarr;', 'sage')) !!}
                </li>
              @endif
            </ul>
          </nav>
        @endif
      @endif

      @if (! comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments'))
        <x-alert type="warning">
          {!! __('Comments are closed.', 'sage') !!}
        </x-alert>
      @endif

      @if (comments_open())
        <div class="comment-form-shell">
          @php
            $commenter = wp_get_current_commenter();
            $req = get_option('require_name_email');
            $ariaReq = $req ? " aria-required='true' required" : '';

            comment_form([
              'title_reply' => __('Add new comment', 'sage'),
              'title_reply_before' => '<h3 class="comment-reply-title">',
              'title_reply_after' => '</h3>',
              'comment_notes_before' => '',
              'comment_notes_after' => '',
              'cancel_reply_before' => '<div class="comment-cancel-reply">',
              'cancel_reply_after' => '</div>',
              'label_submit' => __('Post', 'sage'),
              'class_form' => 'comment-form custom-comment-form',
              'class_submit' => 'submit comment-submit-btn',
              'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
              'submit_field' => '<div class="comment-form-grid">%1$s <div class="form-submit-wrap">%2$s</div></div>',
              'fields' => [
                'author' =>
                  '<p class="comment-form-author">' .
                    '<label for="author">' . __('Name', 'sage') . '</label>' .
                    '<input id="author" name="author" type="text" placeholder="' . esc_attr__('Type your name', 'sage') . '" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $ariaReq . ' />' .
                  '</p>',

                'email' =>
                  '<p class="comment-form-email">' .
                    '<label for="email">' . __('Email ID', 'sage') . '</label>' .
                    '<input id="email" name="email" type="email" placeholder="' . esc_attr__('Type your email', 'sage') . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $ariaReq . ' />' .
                  '</p>',
              ],
              'comment_field' =>
                '<p class="comment-form-comment">' .
                  '<label for="comment" class="screen-reader-text">' . __('Comment', 'sage') . '</label>' .
                  '<textarea id="comment" name="comment" cols="45" rows="5" placeholder="' . esc_attr__('Share your thoughts', 'sage') . '" aria-required="true" required></textarea>' .
                '</p>',
            ]);
          @endphp
        </div>
      @endif
    </div>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggle = document.querySelector('[data-comments-toggle]');
      const panel = document.querySelector('#comments-panel');

      if (!toggle || !panel) return;

      toggle.addEventListener('click', function () {
        const expanded = toggle.getAttribute('aria-expanded') === 'true';

        toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        panel.hidden = expanded;
      });
    });
  </script>
@endif