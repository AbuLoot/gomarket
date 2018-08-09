              <nav class="cd-dropdown">
                <h2>GoMarket</h2>
                <a href="#0" class="cd-close">Close</a>
                <ul class="cd-dropdown-content">
                  <?php $traverse = function ($categories) use (&$traverse) { ?>
                    <?php foreach ($categories as $category) : ?>
                      <?php if ($category->children && count($category->children) > 0) : ?>
                        <li class="has-children">
                          <a  href="#"><i class="material-icons">{{ $category->image }}</i> {{ $category->title }} <i class="fa fa-angle-right d-xs-none submenu-icon"></i></a>
                          <ul class="cd-secondary-dropdown is-hidden">
                            <li class="go-back"><a href="#0">Меню</a></li>
                            <!-- <li class="see-all"><a href="/catalog/{{ $category->slug }}">Все {{ $category->title }}</a></li> -->
                            <!-- <li class="has-children"> -->
                              <!-- <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a> -->
                              <!-- <ul class="is-hidden"> -->
                                <!-- <li class="go-back"><a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a></li> -->
                                <?php $traverse($category->children); ?>
                              <!-- </ul> -->
                            <!-- </li> -->
                          </ul>
                        </li>
                      <?php elseif($category->hasParent()) : ?>
                        <li class="see-all text-white"><a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a></li>
                      <?php else : ?>
                        <li><a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php }; ?>
                  <?php $traverse($categories); ?>
                </ul>
              </nav>